<<<<<<< HEAD
<?php $this -> load -> view('include/header_for_new_sale'); ?>
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
.col-sm-33{
	width:21.75%;
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
.col-sm-122{
	width:11.7%;
	float:left;
	min-height: 1px;
    padding-left: 15px;
    padding-right: 0px;
    position: relative;
}
.col-sm-1{
	width:6.333333%;
	float:left;
}
.content-2{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 4px;
}
.content-3{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 4px;
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
	float: left;
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap table {
    width: 100%;
    table-layout: fixed;
}
.wrap-1 {
	margin:0px 0px 0px 0px;
    width: 100%;
}
.wrap-1 table {
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
    width: 100%;
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
}
.new_data_2 tr:nth-child(odd) td {
    background-color: #fff;
}
.inner_table {
	color:#666768;
    height: 430px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    ~overflow-y: auto !important;
}

.inner_table22 {
	color:#666768;
    height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    ~overflow-y: auto !important;
}
.inner_table_2 {
	color:#403e3e;
    height: 46px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    ~overflow-y: auto !important;
}
.inner_table::-webkit-scrollbar {
    width: 2px;
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
.modal
{
	position: fixed;
	z-index: 999;
	height: 100%;
	width: 100%;
	top: 0;
	left: 0;
	background-color: white;
	filter: alpha(opacity=60);
	opacity: 0.6;
	-moz-opacity: 0.8;
}
.center
{
	z-index: 1000;
	margin: 300px auto;
	width: 350px;
	border-radius: 10px;
	filter: alpha(opacity=100);
	opacity: 1;
	-moz-opacity: 1;
}
.center img
{
	margin:0px 0px 0px 100px;
}
</style>
<section class="content-3">
	<div class="row">
		<div class="col-md-12">
			<div class="box">	
				<div class="box-header with-border" style="background: #0f77ab;">
					<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Staff List</h3>
					<a href="<?php echo base_url();?>report_controller/download_staff_list" id="down" style="width:100px;" target="_blank" class="btn btn-primary btn-sm pull-right"><i class="fa fa-download"></i> Download</a>
				</div>
				<div class="box-body">
					<div class="wrap">
						<table class="head">
							<tr>
							  <td>SL No</td>
							  <td>Staff ID</td>
							  <td>Staff Name</td>
							  <td>Address</td>
							  <td>Contact</td>
							  <td>Type</td>
							  <td style="text-align:center;">Action</td>
							</tr>
						</table>
						<div class="inner_table" id="search_data">
						<table class="new_data_2">
						<?php 
						
							$index=1;
							foreach($all_staff->result() as $field)
							{
						?>
							<tr>
							  <td><?php echo $index;?></td>
							  <td><?php echo $field->employee_id;?></td>
							  <td><?php echo $field->employee_name;?></td>
							  <td><?php echo $field->employee_address;?></td>
							  <td><?php echo $field->employee_contact_no;?></td>
							  <td><?php echo $field->employee_type;?></td>
							  <td style="text-align:center;"><a class="btnEdit" style="cursor:pointer;"><i class="fa fa-fw fa-edit"></i></a></td>
							</tr>
							
							<?php
							$index++;
							}
							?>
						</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>
<script type="text/javascript">
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
	var urlx='<?php echo base_url();?>modify_controller/staff_info_edit';
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
	
	var urlx='<?php echo base_url();?>modify_controller/save_staff_info_edit';
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
	var urlx='<?php echo base_url();?>modify_controller/delete_staff';
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
</script>
</div>
=======
<?php $this -> load -> view('include/header_for_new_sale'); ?>
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
.col-sm-33{
	width:21.75%;
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
.col-sm-122{
	width:11.7%;
	float:left;
	min-height: 1px;
    padding-left: 15px;
    padding-right: 0px;
    position: relative;
}
.col-sm-1{
	width:6.333333%;
	float:left;
}
.content-2{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 4px;
}
.content-3{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 4px;
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
	float: left;
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap table {
    width: 100%;
    table-layout: fixed;
}
.wrap-1 {
	margin:0px 0px 0px 0px;
    width: 100%;
}
.wrap-1 table {
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
    width: 100%;
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
}
.new_data_2 tr:nth-child(odd) td {
    background-color: #fff;
}
.inner_table {
	color:#666768;
    height: 430px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    ~overflow-y: auto !important;
}

.inner_table22 {
	color:#666768;
    height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    ~overflow-y: auto !important;
}
.inner_table_2 {
	color:#403e3e;
    height: 46px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    ~overflow-y: auto !important;
}
.inner_table::-webkit-scrollbar {
    width: 2px;
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
.modal
{
	position: fixed;
	z-index: 999;
	height: 100%;
	width: 100%;
	top: 0;
	left: 0;
	background-color: white;
	filter: alpha(opacity=60);
	opacity: 0.6;
	-moz-opacity: 0.8;
}
.center
{
	z-index: 1000;
	margin: 300px auto;
	width: 350px;
	border-radius: 10px;
	filter: alpha(opacity=100);
	opacity: 1;
	-moz-opacity: 1;
}
.center img
{
	margin:0px 0px 0px 100px;
}
</style>
<section class="content-3">
	<div class="row">
		<div class="col-md-12">
			<div class="box">	
				<div class="box-header with-border" style="background: #0f77ab;">
					<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Staff List</h3>
					<a href="<?php echo base_url();?>report_controller/download_staff_list" id="down" style="width:100px;" target="_blank" class="btn btn-primary btn-sm pull-right"><i class="fa fa-download"></i> Download</a>
				</div>
				<div class="box-body">
					<div class="wrap">
						<table class="head">
							<tr>
							  <td>SL No</td>
							  <td>Staff ID</td>
							  <td>Staff Name</td>
							  <td>Address</td>
							  <td>Contact</td>
							  <td>Type</td>
							  <td style="text-align:center;">Action</td>
							</tr>
						</table>
						<div class="inner_table" id="search_data">
						<table class="new_data_2">
						<?php 
						
							$index=1;
							foreach($all_staff->result() as $field)
							{
						?>
							<tr>
							  <td><?php echo $index;?></td>
							  <td><?php echo $field->employee_id;?></td>
							  <td><?php echo $field->employee_name;?></td>
							  <td><?php echo $field->employee_address;?></td>
							  <td><?php echo $field->employee_contact_no;?></td>
							  <td><?php echo $field->employee_type;?></td>
							  <td style="text-align:center;"><a class="btnEdit" style="cursor:pointer;"><i class="fa fa-fw fa-edit"></i></a></td>
							</tr>
							
							<?php
							$index++;
							}
							?>
						</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>
<script type="text/javascript">
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
	var urlx='<?php echo base_url();?>modify_controller/staff_info_edit';
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
	
	var urlx='<?php echo base_url();?>modify_controller/save_staff_info_edit';
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
	var urlx='<?php echo base_url();?>modify_controller/delete_staff';
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
</script>
</div>
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
<?php $this -> load -> view('include/footer'); ?>