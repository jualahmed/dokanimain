<<<<<<< HEAD
<?php $this -> load -> view('include/header_for_new_sale'); ?>
<!--script  src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.min.js"></script-->
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
<style>
.form-control-2{
	border-color: #d2d6de;
    border-radius: 0;
    box-shadow: none;
	background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    color: #555;
    display: block;
    font-size: 14px;
    height: 34px;
    line-height: 1.42857;
    padding: 6px 14px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100%;
}
.col-xs-4{
	min-height: 1px;
    padding-left: 150px;
    padding-right: 19px;
    position: relative
}

.col-sm-22{
	width:34.75%;
	float:left;
	min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    position: relative;
}
.col-sm-222{
	width:52.8%;
	float:left;
	min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    position: relative;
}
.content-2{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 15px;
}
.content-3{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 15px;
}
.listStyl a{
font-size: 16px;
color: #777;
font-family : arial;
}
#product_show{
	min-width: 382px;
}
#product_show li{
background-color: #f7f7f7;
border: 1px solid #00c0ef;
}
.listStyl a:hover{
    background-color: #00c0ef;
    color:#ffffff;
}
.listStyl a:focus {
    background-color: #00c0ef;
	color: #ffffff;
}

input[type="text"]:disabled {
    background: #dddddd;
}
.wrap {
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap table {
    width: 100%;
    table-layout: fixed;
}

table .new_data tr td {
    border: 1.5px solid #e1e1e1;
	background: white;
}
table tr td {
    padding: 5px;
    border: 1.5px solid #e1e1e1;
    width: 100px;
    word-wrap: break-word;
	background: white;
}
table.head tr td {
    color:white;
	background: #4d89a7;
	font-size:14px;
	font-family:Sans Pro; 
	font-weight:bold;
}

.new_data_2 tr:nth-child(even) td {
    background-color: #e4f1ff;
	cursor: pointer;
}
.new_data_2 tr:nth-child(odd) td {
    background-color: #fff;
	cursor: pointer;
}
.inner_table {
	color:#403e3e;
    height: 285px;
	width: 100%;
	font-size:12px;
	font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table::-webkit-scrollbar {
    width: 4px;
	background-color: #2d3335;
}

.inner_table::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: white;
}

.inner_table::-webkit-scrollbar-thumb {
   background-color: #448ca6;
   background-image: -webkit-linear-gradient(45deg,rgba(255, 255, 255, .2) 25%,transparent 25%,transparent 50%,rgba(255, 255, 255, .2) 50%,rgba(255, 255, 255, .2) 75%,transparent 75%,transparent)

}
</style>
	<section class="content2" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-header with-border" style="background:#0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Distributor Modify</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>modify_controller/get_distributor_info_modify" class="form-horizontal" method="post" enctype="multipart/form-data" id="form_4">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Status</label>
								<div class="col-sm-5">
									<select name="status" class="form-control company_name select10 four" id="lock4" tabindex="-1" aria-hidden="true">
										<option value="">Select Status</option>
										<option value="all">All</option>
									</select>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<a href="<?php echo base_url();?>report_controller/all_distributor_download" id="down" style="display:none;" target="_blank" class="btn btn-primary btn-sm down"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="content" id="infomsg" style="display:none;">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-body">
						<div class="input-group input-group-md">
							<span class="input-group-addon">Distributor</span>
							<input type="text" class="form-control" id="search_member" placeholder="Search for Distributor.." title="Type in a name">
						</div>
						<div class="wrap">
							<table class="head">
								<tr>
									<td style="text-align:center;width: 4%;">No </td> 
									<td style="text-align:center;width: 4%;">ID </td>
									<td style="text-align:center;">Name</td>
									<td style="text-align:center;">Address</td>
									<td style="text-align:center;">Contact</td>
									<td style="text-align:center;">Email</td>
									<td style="text-align:center;">Description</td>
									<td style="text-align:center;">Balance</td>
									<td style="text-align:center;">Action</td> 
								</tr>
							</table>
							<div class="inner_table new_data_2" id="search_data"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

<script>
$('#search_member').keyup(function() 
{
	var rows = $('#myTable tr');
	var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

	rows.show().filter(function() {
		var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
		return !~text.indexOf(val);
	}).hide();
});
</script>
<script>
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
					output2+='<table class="new_data_2" id="myTable"><tr><td style="width: 4%;">'+k+'</td><td style="width: 4%;">'+result[i].distributor_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].distributor_name+'">'+result[i].distributor_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].distributor_address+'" >'+result[i].distributor_address+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].distributor_contact_no+'" >'+result[i].distributor_contact_no+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].distributor_email+'" >'+result[i].distributor_email+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].distributor_description+'" >'+result[i].distributor_description+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].int_balance+'" >'+result[i].int_balance+'</td><td style="text-align:center;"><a class="btnEdit" style="cursor:pointer;"><i class="fa fa-fw fa-edit"></i></a> | <a class="btnDelete" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></a></td></tr></table>';
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
			}
		});
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
	var td_distributor_name = par.children("td:nth-child(3)");
	var td_distributor_address = par.children("td:nth-child(4)");
	var td_distributor_contact = par.children("td:nth-child(5)");
	var td_distributor_email = par.children("td:nth-child(6)");
	var td_distributor_description = par.children("td:nth-child(7)");
	var td_distributor_balance = par.children("td:nth-child(8)");
	var tdButtons = par.children("td:nth-child(9)"); 
	var urlx='<?php echo base_url();?>modify_controller/distributor_info_edit';
	var id=td_Id.html();
	$.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'id':id},
		success:function(result){					
			td_distributor_name.html("<input type='text' class='form-control ctd_distributor_name' style='float:left;width: 100%;' value='"+td_distributor_name.html()+"'/>");						
			td_distributor_address.html("<input type='text' class='form-control ctd_distributor_address' style='float:left;width:100%;' value='"+td_distributor_address.html()+"'/>"); 
			td_distributor_contact.html("<input type='text' class='form-control ctd_distributor_contact' style='float:left;width:100%;' value='"+td_distributor_contact.html()+"'/>"); 
			td_distributor_email.html("<input type='text' class='form-control ctd_distributor_email' style='float:left;width:100%;' value='"+td_distributor_email.html()+"'/>"); 
			td_distributor_description.html("<input type='text' class='form-control ctd_distributor_description' style='float:left;width:100%;' value='"+td_distributor_description.html()+"'/>");
			td_distributor_balance.html("<input type='number' class='form-control ctd_distributor_balance' style='float:left;width:100%;' value='"+td_distributor_balance.html()+"'/>"); 
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
	var td_distributor_name = par.children("td:nth-child(3)");
	var td_distributor_address = par.children("td:nth-child(4)");
	var td_distributor_contact = par.children("td:nth-child(5)");
	var td_distributor_email = par.children("td:nth-child(6)");
	var td_distributor_description = par.children("td:nth-child(7)");
	var td_distributor_balance = par.children("td:nth-child(8)");
	var tdButtons = par.children("td:nth-child(9)"); 
	
	var urlx='<?php echo base_url();?>modify_controller/save_distributor_info_edit';
	var hid=td_Id.html();
	var distributor_name=td_distributor_name.find('.ctd_distributor_name').val();
	var distributor_address=td_distributor_address.find('.ctd_distributor_address').val();
	var distributor_contact=td_distributor_contact.find('.ctd_distributor_contact').val();
	var distributor_email=td_distributor_email.find('.ctd_distributor_email').val();
	var distributor_description=td_distributor_description.find('.ctd_distributor_description').val();
	var distributor_balance=td_distributor_balance.find('.ctd_distributor_balance').val();

	  $.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'hid':hid,'distributor_name':distributor_name,'distributor_address':distributor_address,'distributor_contact':distributor_contact,'distributor_email':distributor_email,'distributor_description':distributor_description,'distributor_balance':distributor_balance},
		success:function(result)
		{				
			td_Id.html(result.distributor_id); 
			td_distributor_name.html(result.distributor_name);
			td_distributor_address.html(result.distributor_address);
			td_distributor_contact.html(result.distributor_contact_no);
			td_distributor_email.html(result.distributor_email);
			td_distributor_description.html(result.distributor_description);
			td_distributor_balance.html(result.int_balance);
			tdButtons.html("<a class='btnEdit' style='cursor:pointer;'><i class='fa fa-fw fa-edit'></i></a> | <a class='btnDelete' style='cursor:pointer;'><i class='fa fa-fw fa-close'></i></a>");
		},
		error: function (jXHR, textStatus, errorThrown) {}
	}); 		
}
			
$(document).on("click", ".btnDelete", function() {
	if (confirm("Are you sure?")) {
	var par = $(this).parent().parent();
	deleter(par);
	
	}
	return false;
});
			
function deleter(par) 
{
	var td_Id = par.children("td:nth-child(2)");
	var urlx='<?php echo base_url();?>modify_controller/delete_distributor';
	var id=tdId.html();
	 $.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'id':id},
		success:function(result)
		{	
			alert("Successfully Delete Distributor.");
		},
		error: function (jXHR, textStatus, errorThrown) {}
	}); 
	
	par.remove();
 
}	
</script>
</div>
=======
<?php $this -> load -> view('include/header'); ?>
<!--script  src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.min.js"></script-->
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
<style>
.form-control-2{
	border-color: #d2d6de;
    border-radius: 0;
    box-shadow: none;
	background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    color: #555;
    display: block;
    font-size: 14px;
    height: 34px;
    line-height: 1.42857;
    padding: 6px 14px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100%;
}
.col-xs-4{
	min-height: 1px;
    padding-left: 150px;
    padding-right: 19px;
    position: relative
}

.col-sm-22{
	width:34.75%;
	float:left;
	min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    position: relative;
}
.col-sm-222{
	width:52.8%;
	float:left;
	min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    position: relative;
}
.content-2{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 15px;
}
.content-3{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 15px;
}
.listStyl a{
font-size: 16px;
color: #777;
font-family : arial;
}
#product_show{
	min-width: 382px;
}
#product_show li{
background-color: #f7f7f7;
border: 1px solid #00c0ef;
}
.listStyl a:hover{
    background-color: #00c0ef;
    color:#ffffff;
}
.listStyl a:focus {
    background-color: #00c0ef;
	color: #ffffff;
}

input[type="text"]:disabled {
    background: #dddddd;
}
.wrap {
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap table {
    width: 100%;
    table-layout: fixed;
}

table .new_data tr td {
    border: 1.5px solid #e1e1e1;
	background: white;
}
table tr td {
    padding: 5px;
    border: 1.5px solid #e1e1e1;
    width: 100px;
    word-wrap: break-word;
	background: white;
}
table.head tr td {
    color:white;
	background: #4d89a7;
	font-size:14px;
	font-family:Sans Pro; 
	font-weight:bold;
}

.new_data_2 tr:nth-child(even) td {
    background-color: #e4f1ff;
	cursor: pointer;
}
.new_data_2 tr:nth-child(odd) td {
    background-color: #fff;
	cursor: pointer;
}
.inner_table {
	color:#403e3e;
    height: 285px;
	width: 100%;
	font-size:12px;
	font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table::-webkit-scrollbar {
    width: 4px;
	background-color: #2d3335;
}

.inner_table::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: white;
}

.inner_table::-webkit-scrollbar-thumb {
   background-color: #448ca6;
   background-image: -webkit-linear-gradient(45deg,rgba(255, 255, 255, .2) 25%,transparent 25%,transparent 50%,rgba(255, 255, 255, .2) 50%,rgba(255, 255, 255, .2) 75%,transparent 75%,transparent)

}
</style>
	<section class="content2" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-header with-border" style="background:#0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Distributor Modify</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>modify_controller/get_distributor_info_modify" class="form-horizontal" method="post" enctype="multipart/form-data" id="form_4">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Status</label>
								<div class="col-sm-5">
									<select name="status" class="form-control company_name select10 four" id="lock4" tabindex="-1" aria-hidden="true">
										<option value="">Select Status</option>
										<option value="all">All</option>
									</select>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<a href="<?php echo base_url();?>report_controller/all_distributor_download" id="down" style="display:none;" target="_blank" class="btn btn-primary btn-sm down"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="content" id="infomsg" style="display:none;">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-body">
						<div class="input-group input-group-md">
							<span class="input-group-addon">Distributor</span>
							<input type="text" class="form-control" id="search_member" placeholder="Search for Distributor.." title="Type in a name">
						</div>
						<div class="wrap">
							<table class="head">
								<tr>
									<td style="text-align:center;width: 4%;">No </td> 
									<td style="text-align:center;width: 4%;">ID </td>
									<td style="text-align:center;">Name</td>
									<td style="text-align:center;">Address</td>
									<td style="text-align:center;">Contact</td>
									<td style="text-align:center;">Email</td>
									<td style="text-align:center;">Description</td>
									<td style="text-align:center;">Balance</td>
									<td style="text-align:center;">Action</td> 
								</tr>
							</table>
							<div class="inner_table new_data_2" id="search_data"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

<script>
$('#search_member').keyup(function() 
{
	var rows = $('#myTable tr');
	var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

	rows.show().filter(function() {
		var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
		return !~text.indexOf(val);
	}).hide();
});
</script>
<script>
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
					output2+='<table class="new_data_2" id="myTable"><tr><td style="width: 4%;">'+k+'</td><td style="width: 4%;">'+result[i].distributor_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].distributor_name+'">'+result[i].distributor_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].distributor_address+'" >'+result[i].distributor_address+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].distributor_contact_no+'" >'+result[i].distributor_contact_no+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].distributor_email+'" >'+result[i].distributor_email+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].distributor_description+'" >'+result[i].distributor_description+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].int_balance+'" >'+result[i].int_balance+'</td><td style="text-align:center;"><a class="btnEdit" style="cursor:pointer;"><i class="fa fa-fw fa-edit"></i></a> | <a class="btnDelete" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></a></td></tr></table>';
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
			}
		});
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
	var td_distributor_name = par.children("td:nth-child(3)");
	var td_distributor_address = par.children("td:nth-child(4)");
	var td_distributor_contact = par.children("td:nth-child(5)");
	var td_distributor_email = par.children("td:nth-child(6)");
	var td_distributor_description = par.children("td:nth-child(7)");
	var td_distributor_balance = par.children("td:nth-child(8)");
	var tdButtons = par.children("td:nth-child(9)"); 
	var urlx='<?php echo base_url();?>modify_controller/distributor_info_edit';
	var id=td_Id.html();
	$.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'id':id},
		success:function(result){					
			td_distributor_name.html("<input type='text' class='form-control ctd_distributor_name' style='float:left;width: 100%;' value='"+td_distributor_name.html()+"'/>");						
			td_distributor_address.html("<input type='text' class='form-control ctd_distributor_address' style='float:left;width:100%;' value='"+td_distributor_address.html()+"'/>"); 
			td_distributor_contact.html("<input type='text' class='form-control ctd_distributor_contact' style='float:left;width:100%;' value='"+td_distributor_contact.html()+"'/>"); 
			td_distributor_email.html("<input type='text' class='form-control ctd_distributor_email' style='float:left;width:100%;' value='"+td_distributor_email.html()+"'/>"); 
			td_distributor_description.html("<input type='text' class='form-control ctd_distributor_description' style='float:left;width:100%;' value='"+td_distributor_description.html()+"'/>");
			td_distributor_balance.html("<input type='number' class='form-control ctd_distributor_balance' style='float:left;width:100%;' value='"+td_distributor_balance.html()+"'/>"); 
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
	var td_distributor_name = par.children("td:nth-child(3)");
	var td_distributor_address = par.children("td:nth-child(4)");
	var td_distributor_contact = par.children("td:nth-child(5)");
	var td_distributor_email = par.children("td:nth-child(6)");
	var td_distributor_description = par.children("td:nth-child(7)");
	var td_distributor_balance = par.children("td:nth-child(8)");
	var tdButtons = par.children("td:nth-child(9)"); 
	
	var urlx='<?php echo base_url();?>modify_controller/save_distributor_info_edit';
	var hid=td_Id.html();
	var distributor_name=td_distributor_name.find('.ctd_distributor_name').val();
	var distributor_address=td_distributor_address.find('.ctd_distributor_address').val();
	var distributor_contact=td_distributor_contact.find('.ctd_distributor_contact').val();
	var distributor_email=td_distributor_email.find('.ctd_distributor_email').val();
	var distributor_description=td_distributor_description.find('.ctd_distributor_description').val();
	var distributor_balance=td_distributor_balance.find('.ctd_distributor_balance').val();

	  $.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'hid':hid,'distributor_name':distributor_name,'distributor_address':distributor_address,'distributor_contact':distributor_contact,'distributor_email':distributor_email,'distributor_description':distributor_description,'distributor_balance':distributor_balance},
		success:function(result)
		{				
			td_Id.html(result.distributor_id); 
			td_distributor_name.html(result.distributor_name);
			td_distributor_address.html(result.distributor_address);
			td_distributor_contact.html(result.distributor_contact_no);
			td_distributor_email.html(result.distributor_email);
			td_distributor_description.html(result.distributor_description);
			td_distributor_balance.html(result.int_balance);
			tdButtons.html("<a class='btnEdit' style='cursor:pointer;'><i class='fa fa-fw fa-edit'></i></a> | <a class='btnDelete' style='cursor:pointer;'><i class='fa fa-fw fa-close'></i></a>");
		},
		error: function (jXHR, textStatus, errorThrown) {}
	}); 		
}
			
$(document).on("click", ".btnDelete", function() {
	if (confirm("Are you sure?")) {
	var par = $(this).parent().parent();
	deleter(par);
	
	}
	return false;
});
			
function deleter(par) 
{
	var td_Id = par.children("td:nth-child(2)");
	var urlx='<?php echo base_url();?>modify_controller/delete_distributor';
	var id=tdId.html();
	 $.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'id':id},
		success:function(result)
		{	
			alert("Successfully Delete Distributor.");
		},
		error: function (jXHR, textStatus, errorThrown) {}
	}); 
	
	par.remove();
 
}	
</script>
</div>
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
<?php $this -> load -> view('include/footer'); ?>