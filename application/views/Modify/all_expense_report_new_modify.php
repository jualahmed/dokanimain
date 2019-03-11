<?php $this -> load -> view('include/header'); ?>
<!--script  src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.min.js"></script-->
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
	<?php 
		if($status !=''){
			 if($status == "successful")
			 {
				 echo '<div class="box-body">';
				 echo $this->session->flashdata('msg1');
				 echo '</div>';
			 }
			 else if($status = '')
			 {
				 echo '<div class="box-body">';
				 echo 'No New Update';
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
    height: 235px;
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
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-header with-border" style="background:#0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Expense Modify</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>modify_controller/all_expense_report_find_new" class="form-horizontal" method="post" enctype="multipart/form-data" id="form_4">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Daily Expense</label>
								<div class="col-sm-4">
									<?php 
										echo form_dropdown('expense_name', $expense_name, '','class="form-control-2 select3" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" id="lock4" tabindex="-1" aria-hidden="true"');
									?>
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
<input type="hidden" id="receipt">
<input type="hidden" id="expense">
<section class="content-3" id="infomsg" style="display:none;">
	<div class="row">
		<div class="col-md-12">
			<div class="box">	 
				<div class="box-body">
					<div class="wrap">
						<table class="head">
							<tr>
							  <td style="width:28px;">No</td>
							  <td style="width:44px;">Expense ID</td>
							  <td>Expense</td>
							  <td>Expense Amount</td>
							  <td>Date</td>
							  <td>Action</td>
							</tr>
						</table>
						<div class="inner_table" id="search_data">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>
<div class="modal fade" id="add_shop_1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> Update Expense</h4>
      </div>
      <div class="modal-body">
		<span id="user-availability-status1" style="display:none;"></span>
        <span id="user-availability-status2" style="display:none;"></span>
		<span id="user-availability-status11" style="display:none;"></span>
        <span id="user-availability-status22" style="display:none;"></span>
		<span id="profile_show_3"></span>
		<img src="<?php echo base_url();?>assets/assets2/LoaderIcon.gif" id="loaderIcon2" style="display:none" />
		<img src="<?php echo base_url();?>assets/assets2/LoaderIcon.gif" id="loaderIcon_2" style="display:none" />
        
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
		$("#form_4").submit(function(event) {
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
					output2+='<table class="new_data_2"><tr><td style="width:28px;">'+k+'</td><td style="width:44px;">'+result[i].expense_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].expense_type+'">'+result[i].type_type+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].expense_amount+'" >'+result[i].expense_amount+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].expense_doc+'">'+result[i].expense_doc+'</td><td><center><a href="#" onclick="myFunction('+result[i].expense_id+')" class="modal_load_3" valuuu ="'+result[i].expense_id+'" data-toggle="modal" data-target="#add_shop_1"><i class="fa fa-fw fa-edit" title="Edit Expense"></i></a></center></td></tr></table>';
					k++;
					//var expense_idd = result[0].expense_id;
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
				var receipt1 =(unescape($('#lock').val()));
				var expense1 =(unescape($('#lock4').val()));
				
				//alert(product_idd);
				$('#receipt').val(receipt1);	
				$('#expense').val(expense1);	
				//$('#product_id_1').val(expense_idd);	
				$('.receipt2').text(receipt1);
				$('.expense2').text(expense1);
				
				$('#lock').val('');
				$('#lock').select2();
				$('#lock4').val('');
				$('#lock4').select2();
			}
		});
	});
});


</script>

<script type="text/javascript">

function myFunction(id){
		var outputs22="";
		$.ajax({
			url: '<?php echo base_url();?>modify_controller/get_expense_info', 
			dataType:'json',
			method: 'POST',
			data: {'expense_id' : id},
			success: function(result)
			{
				outputs22+='<section class="content"><div class="row"><div class="col-md-12"><div class="box box-info"><form action="<?php echo base_url();?>modify_controller/update_expense_info" method="POST" enctype="multipart/form-data" role="form"><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Expense Amount</label><div class="col-sm-10"><input type="text" class="form-control" name="expense_amount" value="'+result.expense_amount+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Total Paid</label><div class="col-sm-10"><input type="text" class="form-control" name="total_paid" value="'+result.total_paid+'"></div></div><input type="hidden" name="expense_id" value="'+result.expense_id+'"><input type="submit" id="submit_btn_1" class="btn btn-block btn-success col-md-offset-2" style="width:116px; margin:10px 0px 0px 206px;" value="Update"></form></div></div></div></section>';
				
				$("#profile_show_3").html(outputs22);
			}
		}); 
	};
  
</script>
<script type="text/javascript">
$(document).ready(function() {
		$("#reset_btn").click(function(event) {
		event.preventDefault();
				$('#lock').val('');
				$('#lock').select2();
				$('#lock4').val('');
				$('#lock4').select2();
		});
	});
</script>
<script>
function checkAvailability() {
	$("#loaderIcon2").show();
	$.ajax({
	url: "<?php echo base_url();?>product_controller/check_barcode_1",
	data:'barcode='+$("#barcode_1").val(),
	type: "POST",
	success:function(data){
		if(data == 'Barcode Available') 
		{
			$('#submit_btn_1').removeAttr('disabled',false);
			$("#user-availability-status1").html(data).show();
			$("#user-availability-status2").html(data).hide()
			$("#loaderIcon2").hide();
		}
		else if (data == 'Barcode Not Available') 
		{
			$('#submit_btn_1').attr('disabled', true);
			$("#user-availability-status2").html(data).show();
			$("#user-availability-status1").html(data).hide();
			$("#loaderIcon2").hide();
		}
	}
	});
}
</script>
<script>
function checkAvailability1() {
	$("#loaderIcon_2").show();
	$.ajax({
	url: "<?php echo base_url();?>product_controller/check_product_2",
	data:'product_name='+$("#product_name_2").val(),
	type: "POST",
	success:function(data){
		if(data == 'Product Name Available') 
		{
			$('#submit_btn_1').removeAttr('disabled',false);
			$("#user-availability-status11").html(data).show();
			$("#user-availability-status22").html(data).hide()
			$("#loaderIcon_2").hide();
		}
		else if (data == 'Product Name Not Available') 
		{
			$('#submit_btn_1').attr('disabled', true);
			$("#user-availability-status22").html(data).show();
			$("#user-availability-status11").html(data).hide();
			$("#loaderIcon_2").hide();
		}
	}
	});
}
</script>
<style>
#user-availability-status11{color:#2FC332;}
#user-availability-status22{color:#D60202;}
#user-availability-status1{color:#2FC332;}
#user-availability-status2{color:#D60202;}
</style>
</div>
<?php $this -> load -> view('include/footer'); ?>