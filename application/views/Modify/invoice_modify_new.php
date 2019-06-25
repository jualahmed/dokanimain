<?php $this -> load -> view('include/header_for_new_sale'); ?>
<script  src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.min.js"></script>
<script src="<?php echo base_url();?>assets/assets2/plugins/datepicker/bootstrap-datepicker.js"></script>
<div class="content-wrapper">
	<?php 
		if($status !=''){
			 if($status == "successful")
			 {
				 echo '<div class="box-body">';
				 echo $this->session->flashdata('msg1');
				 echo '</div>';
			 }
			 else if($status == "failed")
			 {
				 echo '<div class="box-body">';
				 echo $this->session->flashdata('msg2');
				 echo '</div>';
			 }
		 }
	 ?>
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
    height: 300px;
	width: 100%;
	font-size:12px;
	font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
	font-weight:bold;
    overflow-y: auto !important;
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
 .modal1234
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
	<section class="content2" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border" style="background:#0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Invoice Modify</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>modify_controller/get_invoice_info_modify" class="form-horizontal" autocomplete="off" method="post" enctype="multipart/form-data" id="form_4">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Invoice ID</label>
								<div class="col-sm-3">
									<input type="text" name="invoice_id" class="form-control" id="invoice_id" placeholder="Invoice ID" tabindex="3" title="Invoice ID">
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Date</label>
								<div class="col-sm-2">
									<input type="text" name="start_date" class="form-control" id="datepickerrr" placeholder="Star Date" tabindex="3" title="Start Date">
								</div>
								<div class="col-sm-2">
									<input type="text" name="end_date" class="form-control" id="datepickerr" placeholder="End Date" title="End Date">
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
								</div>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="modal1234" style="display: none">
		<div class="center">
			<img src="<?php echo base_url();?>assets/assets2/spin.gif" id="loaderIcon2"/>
		</div>
	</div>
	<section class="content-3" id="infomsg" style="display:none;">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-body">
						<div class="input-group input-group-md">
							<span class="input-group-addon">Invoice</span>
							<input type="text" class="form-control" id="search_invoice" placeholder="Search for Invoice.." title="Search for Invoice..">
						</div>
						<div class="wrap">
							<table class="head">
								<tr>
									<td style="text-align:center;">No</td> 
									<td style="text-align:center;">Invoice ID</td>
									<td style="text-align:center;">Invoice Date</td>
									<td style="text-align:center;">Invoice Amount</td>
									<td style="text-align:center;">Invoice Creator</td>
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
$('#search_invoice').keyup(function() 
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
					output2+='<table class="new_data_2" id="myTable"><tr><td style="text-align:center;">'+k+'</td><td style="text-align:center;">'+result[i].invoice_id+'</td><td style="text-align:center;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].invoice_doc+'">'+result[i].invoice_doc+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].total_price+'" >'+result[i].total_price+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].user_full_name+'" >'+result[i].user_full_name+'</td><td style="text-align:center;"><a class="btnDelete" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></a></tr></table>';
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
	var urlx='<?php echo base_url();?>modify_controller/modify_single_invoice';
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
</script>
</div>
<?php $this -> load -> view('include/footer'); ?>