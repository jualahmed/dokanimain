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
	<section class="content-3">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border" style="background:#0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Bank Modify</h3>
					</div>
					<div class="box-body">
						<div class="input-group input-group-md">
							<span class="input-group-addon">Bank</span>
							<input type="text" class="form-control" id="search_member" placeholder="Search for Bank.." title="Type in a name">
						</div>
						<div class="wrap">
							<table class="head">
								<tr>
									<td style="text-align:center;">No </td> 
									<td style="text-align:left;">Name</td>
									<td style="text-align:left;">Account Name</td>
									<td style="text-align:left;">Account No</td>
									<td style="text-align:left;">Description</td>
									<td style="text-align:center;">Action</td>
								</tr>
							</table>
							<div class="inner_table new_data_2" id="search_data">
								<table class="new_data_2" id="myTable">
								<?php
								$i=1;
								foreach($records->result() as $tmp)
								{
								?>
								<tr>
									<td style="text-align:center;"><?php echo $i;?></td>
									<td style="display:none;"><?php echo $tmp->bank_id;?></td>
									<td style="text-align:left;"><?php echo $tmp->bank_name;?></td>
									<td style="text-align:left;"><?php echo $tmp->bank_account_name;?></td>
									<td style="text-align:left;"><?php echo $tmp->bank_account_no;?></td>
									<td style="text-align:left;"><?php echo $tmp->bank_description;?></td>
									<td style="text-align:center;"><a class="btnEdit" style="cursor:pointer;"><i class="fa fa-fw fa-edit"></i></a> | <a class="btnDelete" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></a></td>
								</tr>
								<?php
								$i++;
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
$(document).on("click", ".btnEdit", function() 
{
	var par = $(this).parent().parent();
	editr(par);
});
	
function editr(par) 
{
	var tdserial = par.children("td:nth-child(1)"); 
	var td_Id = par.children("td:nth-child(2)");
	var td_bank_name = par.children("td:nth-child(3)");
	var td_account_name = par.children("td:nth-child(4)");
	var td_account_no = par.children("td:nth-child(5)");
	var td_account_description = par.children("td:nth-child(6)");
	var tdButtons = par.children("td:nth-child(7)"); 
	var urlx='<?php echo base_url();?>modify_controller/bank_info_edit';
	var id=td_Id.html();
	$.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'id':id},
		success:function(result){					
			td_bank_name.html("<input type='text' class='form-control ctd_bank_name' style='float:left;width: 100%;' value='"+td_bank_name.html()+"'/>");						
			td_account_name.html("<input type='text' class='form-control ctd_account_name' style='float:left;width:100%;' value='"+td_account_name.html()+"'/>"); 
			td_account_no.html("<input type='text' class='form-control ctd_account_no' style='float:left;width:100%;' value='"+td_account_no.html()+"'/>"); 
			td_account_description.html("<input type='text' class='form-control ctd_account_description' style='float:left;width:100%;' value='"+td_account_description.html()+"'/>"); 
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
	var td_bank_name = par.children("td:nth-child(3)");
	var td_account_name = par.children("td:nth-child(4)");
	var td_account_no = par.children("td:nth-child(5)");
	var td_account_description = par.children("td:nth-child(6)");
	var tdButtons = par.children("td:nth-child(7)"); 
	
	var urlx='<?php echo base_url();?>modify_controller/save_bank_info_edit';
	var hid=td_Id.html();
	var bank_name=td_bank_name.find('.ctd_bank_name').val();
	var account_name=td_account_name.find('.ctd_account_name').val();
	var account_no=td_account_no.find('.ctd_account_no').val();
	var account_description=td_account_description.find('.ctd_account_description').val();

	  $.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'hid':hid,'bank_name':bank_name,'account_name':account_name,'account_no':account_no,'account_description':account_description},
		success:function(result)
		{				
			td_bank_name.html(result.bank_name);
			td_account_name.html(result.bank_account_name);
			td_account_no.html(result.bank_account_no);
			td_account_description.html(result.bank_description);
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
	var urlx='<?php echo base_url();?>modify_controller/delete_bank';
	var id=td_Id.html();
	 $.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'id':id},
		success:function(result)
		{	
			alert("Successfully Delete Bank.");
		},
		error: function (jXHR, textStatus, errorThrown) {}
	}); 
	
	par.remove();
 
}	
</script>
</div>
<?php $this -> load -> view('include/footer'); ?>