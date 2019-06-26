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
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Category Modify</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>modify_controller/get_catagory_info_modify" class="form-horizontal" method="post" enctype="multipart/form-data" id="form_4">
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
									<a href="<?php echo base_url();?>report_controller/all_catagory_download" id="down" style="display:none;" target="_blank" class="btn btn-primary btn-sm down"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="content-3" id="infomsg" style="display:none;">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-body">
						<div class="input-group input-group-md">
							<span class="input-group-addon">Catagory</span>
							<input type="text" class="form-control" id="search_member" placeholder="Search for Catagory.." title="Type in a name">
						</div>
						<div class="wrap">
							<table class="head">
								<tr>
									<td style="text-align:center;">No </td> 
									<td style="text-align:center;"> Catagory ID </td>
									<td style="text-align:center;"> Catagory Name</td>
									<td style="text-align:center;"> Catagory Description</td>
									<td style="text-align:center;"> Action </td> 
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
<script type="text/javascript">
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
					output2+='<table class="new_data_2" id="myTable"><tr><td>'+k+'</td><td>'+result[i].catagory_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].catagory_name+'">'+result[i].catagory_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].catagory_description+'" >'+result[i].catagory_description+'</td><td style="text-align:center;"><a class="btnEdit" style="cursor:pointer;"><i class="fa fa-fw fa-edit"></i></a> | <a class="btnDelete" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></a></td></tr></table>';
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
	var td_catagory_name = par.children("td:nth-child(3)");
	var td_catagory_description = par.children("td:nth-child(4)");
	var tdButtons = par.children("td:nth-child(5)"); 
	var urlx='<?php echo base_url();?>modify_controller/catagory_info_edit';
	var id=td_Id.html();
	$.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'id':id},
		success:function(result){					
			td_catagory_name.html("<input type='text' class='form-control ctd_catagory_name' style='float:left;width: 100%;' value='"+td_catagory_name.html()+"'/>");						
			td_catagory_description.html("<input type='text' class='form-control ctd_catagory_description' style='float:left;width:100%;' value='"+td_catagory_description.html()+"'/>"); 
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
	var td_catagory_name = par.children("td:nth-child(3)");
	var td_catagory_description = par.children("td:nth-child(4)");
	var tdButtons = par.children("td:nth-child(5)"); 
	
	var urlx='<?php echo base_url();?>modify_controller/save_catagory_info_edit';
	var hid=td_Id.html();
	var catagory_name=td_catagory_name.find('.ctd_catagory_name').val();
	var catagory_description=td_catagory_description.find('.ctd_catagory_description').val();

	  $.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'hid':hid,'catagory_name':catagory_name,'catagory_description':catagory_description},
		success:function(result)
		{				
			td_Id.html(result.catagory_id); 
			td_catagory_name.html(result.catagory_name);
			td_catagory_description.html(result.catagory_description);
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
	var urlx='<?php echo base_url();?>modify_controller/delete_catagory';
	var id=td_Id.html();
	 $.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'id':id},
		success:function(result)
		{	
			alert("Successfully Delete Catagory.");
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
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Category Modify</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>modify_controller/get_catagory_info_modify" class="form-horizontal" method="post" enctype="multipart/form-data" id="form_4">
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
									<a href="<?php echo base_url();?>report_controller/all_catagory_download" id="down" style="display:none;" target="_blank" class="btn btn-primary btn-sm down"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="content-3" id="infomsg" style="display:none;">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-body">
						<div class="input-group input-group-md">
							<span class="input-group-addon">Catagory</span>
							<input type="text" class="form-control" id="search_member" placeholder="Search for Catagory.." title="Type in a name">
						</div>
						<div class="wrap">
							<table class="head">
								<tr>
									<td style="text-align:center;">No </td> 
									<td style="text-align:center;"> Catagory ID </td>
									<td style="text-align:center;"> Catagory Name</td>
									<td style="text-align:center;"> Catagory Description</td>
									<td style="text-align:center;"> Action </td> 
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
<script type="text/javascript">
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
					output2+='<table class="new_data_2" id="myTable"><tr><td>'+k+'</td><td>'+result[i].catagory_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].catagory_name+'">'+result[i].catagory_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].catagory_description+'" >'+result[i].catagory_description+'</td><td style="text-align:center;"><a class="btnEdit" style="cursor:pointer;"><i class="fa fa-fw fa-edit"></i></a> | <a class="btnDelete" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></a></td></tr></table>';
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
	var td_catagory_name = par.children("td:nth-child(3)");
	var td_catagory_description = par.children("td:nth-child(4)");
	var tdButtons = par.children("td:nth-child(5)"); 
	var urlx='<?php echo base_url();?>modify_controller/catagory_info_edit';
	var id=td_Id.html();
	$.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'id':id},
		success:function(result){					
			td_catagory_name.html("<input type='text' class='form-control ctd_catagory_name' style='float:left;width: 100%;' value='"+td_catagory_name.html()+"'/>");						
			td_catagory_description.html("<input type='text' class='form-control ctd_catagory_description' style='float:left;width:100%;' value='"+td_catagory_description.html()+"'/>"); 
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
	var td_catagory_name = par.children("td:nth-child(3)");
	var td_catagory_description = par.children("td:nth-child(4)");
	var tdButtons = par.children("td:nth-child(5)"); 
	
	var urlx='<?php echo base_url();?>modify_controller/save_catagory_info_edit';
	var hid=td_Id.html();
	var catagory_name=td_catagory_name.find('.ctd_catagory_name').val();
	var catagory_description=td_catagory_description.find('.ctd_catagory_description').val();

	  $.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'hid':hid,'catagory_name':catagory_name,'catagory_description':catagory_description},
		success:function(result)
		{				
			td_Id.html(result.catagory_id); 
			td_catagory_name.html(result.catagory_name);
			td_catagory_description.html(result.catagory_description);
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
	var urlx='<?php echo base_url();?>modify_controller/delete_catagory';
	var id=td_Id.html();
	 $.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'id':id},
		success:function(result)
		{	
			alert("Successfully Delete Catagory.");
		},
		error: function (jXHR, textStatus, errorThrown) {}
	}); 
	
	par.remove();
 
}	
</script>
</div>
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
<?php $this -> load -> view('include/footer'); ?>