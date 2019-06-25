<?php $this -> load -> view('include/header_for_new_sale'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
<style>
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
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap table {
    width: 100%;
    table-layout: fixed;
}
.wrap-11 {
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap-11 table {
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
    width: 100px;
    word-wrap: break-word;
	background: white;
}
table.head tr td {
    color:white;
	background: #4d89a7;
	font-size:14px;
	font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
	font-weight:bold;
}

.new_data_2 tr:nth-child(even) td {
    background-color: #e4f1ff;
}
.new_data_2 tr:nth-child(odd) td {
    background-color: #fff;
}
.inner_table {
	color:#333;
	max-height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
	font-weight:normal;
	overflow-y: auto !important;
}

.inner_table22 {
	color:#333;
	max-height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
	font-weight:normal;
	overflow-y: auto !important;
}
.inner_table_2 {
	color:#403e3e;
    height: 33px;
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
	<section class="content-2" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Cheque Status Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>account_controller/all_cheque_status_report_find" class="form-horizontal" method="post" autocomplete="off" enctype="multipart/form-data" id="form_6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Cheque Status</label>
								<div class="col-sm-4">
									<select class="form-control select2" name="cheque_status" id="cheque_status">
										<option value="">Select Status</option>
										<option value="active">Hounored</option>
										<option value="inactive">Dishounored</option>
										<option value="deleted">Delete</option>
									</select>
								</div>
								<div class="col-sm-3">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
<div class="modal" style="display: none">
	<div class="center">
		<img src="<?php echo base_url();?>assets2/spin.gif" id="loaderIcon"/>
	</div>
</div>
<input type="hidden" id="investor">
<input type="hidden" id="start">
<input type="hidden" id="end">
<section class="content-3" id="infomsg" style="display:none;">
	<div class="row">
		<div class="col-md-12">
			<div class="box">	 
				<div class="box-body">
					<div class="wrap">
						<table class="head">
							<tr>
							  <td>No</td>
							  <td>Cheque ID</td>
							  <td>Cheque Date</td>
							  <td>Trasaction ID</td>
							  <td>Ledger Name</td>
							  <td>Ledger Type</td>
							  <td>Bank Name</td>
							  <td>Cheque No</td>
							  <td style="text-align:right;"> Amount</td>
							  <td style="text-align:center;">Status</td>
							  <td style="text-align:center;">Action</td>
							</tr>
						</table>
						<div class="inner_table">
							<table class="new_data_2" id="search_data">
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>
<script type="text/javascript">
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
	var urlx='<?php echo base_url();?>modify_controller/cheque_status_edit';
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
	
	var urlx='<?php echo base_url();?>modify_controller/save_cheque_status_edit';
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
</script>
</div>
<?php $this -> load -> view('include/footer'); ?>