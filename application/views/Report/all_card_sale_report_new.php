<<<<<<< HEAD
<?php $this -> load -> view('include/header_for_new_sale'); ?>
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
table .new_data tr td {
    border: 1.5px solid #ffe8e8;
	background: white;
}
table tr td {
    padding: 5px;
    border: 1.5px solid #ffe8e8;
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
    height: 300px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}

.inner_table22 {
	color:#666768;
   max-height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table_2 {
	color:#403e3e;
    max-height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table::-webkit-scrollbar {
    width: 1px;
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
	<section class="content-2" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Card Sale Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>report_controller/all_card_sale_report_find" class="form-horizontal" method="post" autocomplete="off" enctype="multipart/form-data" id="form_4">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Invoice</label>
								<div class="col-sm-2">
									<?php 
										echo form_dropdown('card_id', $card_name, '','class="form-control-2 select2" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" id="lock3" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr", 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">End</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>
								<div class="col-sm-3">
									<button type="submit" class="btn btn-success btn-sm" name="search_random"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a href="<?php echo base_url();?>report_controller/download_data_card_sale" id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration:none;display:none;"><i class="fa fa-download"></i> Down</a>
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
<input type="hidden" id="card">
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
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Date</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Card Name</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Bank Name</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Sale Amount</td>
							</tr>
						</table>
						<div class="inner_table" id="search_data">
						</div>
						<table class="head">
							<tr>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Total Sale</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;" id="finaloutput"></td>
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
		$("#form_4").submit(function(event) {
		event.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		var output = '';
		var output2 = '';
		var output3 = '';
		var finaloutput = 0.00;
		var amount = 0.00;
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
			success: function(result)
			{	
				$(".modal1234").hide();
				finaloutput =0;
				for(i=0; i<result.length; i++)
				{				
					finaloutput+= parseFloat(result[i].amount);
					amount = parseFloat(Math.round(result[i].amount)).toFixed(2);
					output2+='<table class="new_data_2"><tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;" title="'+result[i].date+'">'+result[i].date+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].card_name+'" >'+result[i].card_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;text-align:center;" title="'+result[i].bank_name+'">'+result[i].bank_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;text-align:center;" title="'+result[i].amount+'">'+amount+'</td></tr></table>';
				}
				if(output2 != '' && finaloutput!='')
				{
					$('#finaloutput').html(finaloutput.toFixed(2));
					$('#search_data').html(output2);
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#finaloutput').html("0.00");
					$('#search_data').html("No Data Available");
					$('#infomsg').show();
					$('#down').hide();
				}
				var card_id = $('#lock3').val();
				var start_date = $('#datepickerrr').val();
				var end_date = $('#datepickerr').val();
				
				$('#card').val(card_id);
				$('#start').val(start_date);
				$('#end').val(end_date);
				
				$('#lock3').val('');
				$('#lock3').select2();
				$('#datepickerrr').val('');
				$('#datepickerr').val(''); 

			}
		});
	});
	
	$("#down").click(function(event2) {
		event2.preventDefault();
		submiturl = $(this).attr('href');
		
		var card = $('#card').val();
		var start = $('#start').val();
		var end = $('#end').val();
		
		if(card == ''){
			card = 'null';
		}
		if(start == ''){
			start = 'null';
		}
		if(end == ''){
			end = 'null';
		}

		window.open(submiturl+'/'+card+'/'+start+'/'+end,'_blank');
		
	});

});
</script>
</div>
=======
<?php $this -> load -> view('include/header_for_new_sale'); ?>
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
table .new_data tr td {
    border: 1.5px solid #ffe8e8;
	background: white;
}
table tr td {
    padding: 5px;
    border: 1.5px solid #ffe8e8;
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
    height: 300px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}

.inner_table22 {
	color:#666768;
   max-height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table_2 {
	color:#403e3e;
    max-height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table::-webkit-scrollbar {
    width: 1px;
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
	<section class="content-2" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Card Sale Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>report_controller/all_card_sale_report_find" class="form-horizontal" method="post" autocomplete="off" enctype="multipart/form-data" id="form_4">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Invoice</label>
								<div class="col-sm-2">
									<?php 
										echo form_dropdown('card_id', $card_name, '','class="form-control-2 select2" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" id="lock3" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr", 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">End</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>
								<div class="col-sm-3">
									<button type="submit" class="btn btn-success btn-sm" name="search_random"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a href="<?php echo base_url();?>report_controller/download_data_card_sale" id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration:none;display:none;"><i class="fa fa-download"></i> Down</a>
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
<input type="hidden" id="card">
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
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Date</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Card Name</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Bank Name</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Sale Amount</td>
							</tr>
						</table>
						<div class="inner_table" id="search_data">
						</div>
						<table class="head">
							<tr>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Total Sale</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;" id="finaloutput"></td>
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
		$("#form_4").submit(function(event) {
		event.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		var output = '';
		var output2 = '';
		var output3 = '';
		var finaloutput = 0.00;
		var amount = 0.00;
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
			success: function(result)
			{	
				$(".modal1234").hide();
				finaloutput =0;
				for(i=0; i<result.length; i++)
				{				
					finaloutput+= parseFloat(result[i].amount);
					amount = parseFloat(Math.round(result[i].amount)).toFixed(2);
					output2+='<table class="new_data_2"><tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;" title="'+result[i].date+'">'+result[i].date+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].card_name+'" >'+result[i].card_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;text-align:center;" title="'+result[i].bank_name+'">'+result[i].bank_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;text-align:center;" title="'+result[i].amount+'">'+amount+'</td></tr></table>';
				}
				if(output2 != '' && finaloutput!='')
				{
					$('#finaloutput').html(finaloutput.toFixed(2));
					$('#search_data').html(output2);
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#finaloutput').html("0.00");
					$('#search_data').html("No Data Available");
					$('#infomsg').show();
					$('#down').hide();
				}
				var card_id = $('#lock3').val();
				var start_date = $('#datepickerrr').val();
				var end_date = $('#datepickerr').val();
				
				$('#card').val(card_id);
				$('#start').val(start_date);
				$('#end').val(end_date);
				
				$('#lock3').val('');
				$('#lock3').select2();
				$('#datepickerrr').val('');
				$('#datepickerr').val(''); 

			}
		});
	});
	
	$("#down").click(function(event2) {
		event2.preventDefault();
		submiturl = $(this).attr('href');
		
		var card = $('#card').val();
		var start = $('#start').val();
		var end = $('#end').val();
		
		if(card == ''){
			card = 'null';
		}
		if(start == ''){
			start = 'null';
		}
		if(end == ''){
			end = 'null';
		}

		window.open(submiturl+'/'+card+'/'+start+'/'+end,'_blank');
		
	});

});
</script>
</div>
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
<?php $this -> load -> view('include/footer'); ?>