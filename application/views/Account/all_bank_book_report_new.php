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
    width: 50%;
	margin:0px 0px 0px 0px;
}
.wrap table {
    width: 98%;
    table-layout: fixed;
}
.wrap-11 {
	float: right;
    width: 50%;
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
    ~height: 190px;
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
	<section class="content-2" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Bank Book Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>account/all_bank_book_report_find" method="post" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" id="form_6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-3">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr",'value' => $bd_date, 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">End</label>
								<div class="col-sm-3">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'value' => $bd_date, 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a href="<?php echo base_url();?>account/download_bank_book" id="down" style="display:none;width:100px;" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</a>
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
<input type="hidden" id="start">
<input type="hidden" id="end">
<section class="content-3" id="infomsg" style="display:none;">
	<div class="row">
		<div class="col-md-12">
			<div class="box">	 
				<div class="box-body">
					<div class="wrap">
						<div class="box-header with-border" style="background: #0f77ab;">
							<center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Debit / Inword</h3></center>
						</div>
						<table class="head">
							<tr>
							  <td style="width:4%;">Date</td>
							  <td style="width:4%;">Particular</td>
							  <td style="width: 4%;text-align:right;">Amount</td>
							</tr>
						</table>
						<div class="inner_table" id="search_data">
						</div>
						<table class="head">
							<tr>
							  <td style="width:4%;"></td>
							  <td style="width:4%;">Total</td>
							  <td style="width: 4%;text-align:right;"><span id="total_debit"></span></td>
							</tr>
						</table>
					</div>
					<div class="wrap-11">
						<div class="box-header with-border" style="background: #0f77ab;">
							<center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Credit / Outword</h3></center>
						</div>
						<table class="head">
							<tr>
							  <td style="width:4%;">Date</td>
							  <td style="width:4%;">Particular</td>
							  <td style="width: 4%;text-align:right;">Amount</td>
							</tr>
						</table>
						<div class="inner_table" id="search_data2">
						</div>
						<table class="head">
							<tr>
							  <td style="width:4%;"></td>
							  <td style="width:4%;">Total</td>
							  <td style="width: 4%;text-align:right;"><span id="total_credit"></span></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>
<script type="text/javascript">
$(document).ready(function() {
		$("#form_6").submit(function(event) {
		event.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		var output = '';
		var output2 = '';
		var output3 = '';
		var total_amount1 = 0.00;
		var total_amount2 = 0.00;
		var i=0;
		var k= 0;
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
				total_amount1 = 0.00;
				for(i=0; i<result['credit'].length; i++)
				{	
					var amount1=parseFloat(Math.round(result['credit'][i].amount));
					total_amount1+=parseFloat(Math.round(result['credit'][i].amount));
					//alert(total_amount1);
					output2+='<table><tr><td style="width: 4%;">'+result['credit'][i].date+'</td><td style="width: 4%;">'+result['credit'][i].transaction_purpose+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width: 4%;text-align:right;">'+amount1.toFixed(2)+'</td></tr></table>';
					
				}
				total_amount2 = 0.00;
				for(k=0; k<result['debit'].length; k++)
				{	
					var amount2  =parseFloat(Math.round(result['debit'][k].amount));
					total_amount2+=parseFloat(Math.round(result['debit'][k].amount));
					//alert(total_amount2);
					output3+='<table class="new_data_2"><tr><td style="width: 4%;">'+result['debit'][k].date+'</td><td style="width: 4%;">'+result['debit'][k].transaction_purpose+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width: 4%;text-align:right;">'+amount2.toFixed(2)+'</td></tr></table>';
				}
				if(output2 != '')
				{
					$('#search_data').html(output2);
					$('#total_debit').html(total_amount1.toFixed(2));
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#search_data').html("No Data Available");
					$('#infomsg').show();
					$('#down').show();
				}
				if(output3 != '')
				{
					$('#search_data2').html(output3);
					$('#total_credit').html(total_amount2.toFixed(2));
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#search_data2').html("No Data Available");
					$('#infomsg').show();
					$('#down').show();
				}
				var start1 = $('#datepickerrr').val();
				var end1 = $('#datepickerr').val();
				$('#start').val(start1);
				$('#end').val(end1);
				
				$('.start2').text(start1);
				$('.end2').text(end1);

				//$('#datepickerrr').val('');
				//$('#datepickerr').val('');

			}
		});
	});
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

		window.open(submiturl+'/'+start+'/'+end,'_blank');
	});
	
});
</script>
<script type="text/javascript">
$(document).ready(function() {
		$("#reset_btn").click(function(event) {
		event.preventDefault();
				$('#lock3').val('');
				$('#lock3').select2();
				$('#lock4').val('');
				$('#lock4').select2();
				$('#lock5').val('');
				$('#lock5').select2();
				$('#lock22').val('');
				$('#datep').val('');
				$('#datep2').val('');
		});
	});
</script>
</div>
<?php $this -> load -> view('include/footer'); ?>