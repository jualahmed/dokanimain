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
</style>
		
	<section class="content-2" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-7 col-md-offset-3">
				<div class="box">
					<div class="box-header with-border" style="background:#0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Card Modify</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>modify/all_card_report_find" method="post" class="form-horizontal" enctype="multipart/form-data" id="form_4">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Card</label>
								<div class="col-sm-5">
									<?php 
										echo form_dropdown('card_id', $card_name, '','class="form-control select2" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" id="lock3" tabindex="-1" aria-hidden="true"');
									?>
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
					<span class="text">If you want to make it inactive, then write inactive.</span>
					<br>
					<div class="wrap">
						<table class="head">
							<tr>
								<td style="width:45px;text-align:center;"> Card ID </td> 
								<td style="width:80px;text-align:center;"> Card Name </td>
								<td style="width:80px;text-align:center;"> Status  </td>
								<td style="width:80px;text-align:center;"> Bank Name </td>
								<td style="width:45px;text-align:center;"> Action </td> 
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
					output2+='<table class="new_data_2"><tr><td style="width:45px;text-align:center;">'+result[i].card_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width:80px;text-align:center;" title="'+result[i].card_name+'">'+result[i].card_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;text-align:center;width:80px" title="'+result[i].status+'" >'+result[i].status+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;text-align:center;width:80px" title="'+result[i].bank_name+'">'+result[i].bank_name+'</td><td style="width:45px;text-align:center;"><a class="btnEdit" style="cursor:pointer;"><i class="fa fa-fw fa-edit"></i></a></td></tr></table>';
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
				var product1 = $('#lock22').val();
				
				//alert(product_idd);
				$('#product').val(product1);	
				$('#product_id_1').val(product_idd);	
				$('.product2').text(product1);
				
				$('#lock3').val('');
				$('#lock3').select2();
				$('#lock4').val('');
				$('#lock4').select2();
				$('#lock22').val('');

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
				var td_card_id = par.children("td:nth-child(1)"); 
				var td_card_name = par.children("td:nth-child(2)");
				var td_status = par.children("td:nth-child(3)");
				var td_bank_name = par.children("td:nth-child(4)");
				var tdButtons = par.children("td:nth-child(5)");
				var urlx='<?php echo base_url();?>modify/card_info_edit';
				var id=td_card_id.html();
				$.ajax({
					url: urlx,
					type: 'POST',
					dataType: 'json',
					data: {'id':id},
					success:function(result){						
						td_card_name.html("<center><input type='text' class='form-control ctd_card_name' style='float:left;width:252px;text-align:center;' value='"+td_card_name.html()+"'/></center>");
						td_status.html("<input type='text' class='form-control ctd_status' style='float:left;width:252px;text-align:center;' value='"+td_status.html()+"'/>");
						td_bank_name.html(result['cbn']);						
						tdButtons.html("<a class='btnSave' style='cursor:pointer;'><i class='fa fa-fw fa-check'></i></a>");
					 
						},
					error: function (jXHR, textStatus, errorThrown) {}
				});
			
			}
			
			$(document).on("click", ".btnSave", function() {
			var par = $(this).parent().parent();
			saver(par);

			});
			
			function saver(par) {

			var td_card_id = par.children("td:nth-child(1)"); 
			var td_card_name = par.children("td:nth-child(2)");
			var td_status = par.children("td:nth-child(3)");
			var td_bank_name = par.children("td:nth-child(4)");
			var tdButtons = par.children("td:nth-child(5)");
			
			var urlx='<?php echo base_url();?>modify/save_card_info_edit';
			var hid=td_card_id.html();
			var card_name=td_card_name.find('.ctd_card_name').val();
			var status=td_status.find('.ctd_status').val();
			var bank_id=td_bank_name.find('.ccb').val();
			  $.ajax({
				url: urlx,
				type: 'POST',
				dataType: 'json',
				data: {'hid':hid,'card_name':card_name,'status':status,'bank_id':bank_id},
				success:function(result){				
				
				td_card_id.html(result.card_id); 
				td_card_name.html(result.card_name);
				td_status.html(result.status);
				td_bank_name.html(result.bank_name); 
				tdButtons.html("<a class='btnEdit' style='cursor:pointer;'><i class='fa fa-fw fa-edit'></i></a>");
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
			
			function deleter(par) {
			var tdId = par.children("td:nth-child(1)");
			var urlx='<?php echo base_url();?>modify/delete_productt';
			var id=tdId.html();
			 $.ajax({
				url: urlx,
				type: 'POST',
				dataType: 'json',
				data: {'id':id},
				success:function(result){	
					alert("Successfully Delete Product.");
				},
				error: function (jXHR, textStatus, errorThrown) {}
			}); 
			
			 par.remove();
			 
			}

</script>

<script type="text/javascript">

function myFunction(id){
		var outputs22="";
		$.ajax({
			url: '<?php echo base_url();?>modify/get_product_info', 
			dataType:'json',
			method: 'POST',
			data: {'product_id' : id},
			success: function(result){
			outputs22+='<section class="content"><div class="row"><div class="col-md-12"><div class="box box-info"><form action="<?php echo base_url();?>modify/update_product_info_1" method="POST" enctype="multipart/form-data" role="form"><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Name</label><div class="col-sm-10"><input type="text" class="form-control" id="product_name_2" onBlur="checkAvailability1()" name="product_name" value="'+result.product_name+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Company</label><div class="col-sm-10"><select name="company_name" class="form-control select7" id = "select_comp" style="width: 100%;"></select></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Catagory</label><div class="col-sm-10"><select name="catagory_name" class="form-control select8" id = "select_catagory" style="width: 100%;"></select></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Barcode</label><div class="col-sm-10"><input type="text" class="form-control" id="barcode_1" onBlur="checkAvailability()" name="barcode" value="'+result.barcode+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Stock</label><div class="col-sm-10"><input type="text" class="form-control" name="stock_amount" value="'+result.stock_amount+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">U.BP</label><div class="col-sm-10"><input type="text" class="form-control" name="bulk_unit_buy_price" value="'+result.bulk_unit_buy_price+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">U.SP</label><div class="col-sm-10"><input type="text" class="form-control" name="bulk_unit_sale_price" value="'+result.bulk_unit_sale_price+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">E.SP</label><div class="col-sm-10"><input type="text" class="form-control" name="general_unit_sale_price" value="'+result.general_unit_sale_price+'"></div></div><input type="hidden" name="product_id" value="'+result.product_id+'"><input type="submit" id="submit_btn_1" class="btn btn-block btn-success col-md-offset-2" style="width:116px; margin:10px 0px 0px 206px;" value="Update"></form></div></div></div></section>';
				
				$("#profile_show_3").html(outputs22);
				get_all_company_info(result.company_name);
				get_all_catagory_info(result.catagory_name);
			}
		}); 
	};
	
	
	function get_all_company_info(company_names){
		submiturl = '<?php echo base_url();?>modify/get_all_company_info';
		var output='';
		var flag;
		$.ajax({
			url: submiturl,
			type: 'POST',
			dataType: 'json',
			data: $(this).serialize(),
			success: function(result) {
				for(var i=0;i<result.length;i++){
					if(result[i].company_name == company_names){
						flag = 'selected';
					}
					else{
						flag = '';
					}
					output+='<option value="'+result[i].company_name+'" '+flag+'>'+result[i].company_name+'</option>';
				}
				
				$('#select_comp').html(output);
				
			}
		});
	}
	
	function get_all_catagory_info(catagory_names){
		submiturl = '<?php echo base_url();?>modify/get_all_catagory_info';
		var output='';
		var flag;
		$.ajax({
			url: submiturl,
			type: 'POST',
			dataType: 'json',
			data: $(this).serialize(),
			success: function(result) {
				for(var i=0;i<result.length;i++){
					if(result[i].catagory_name == catagory_names){
						flag = 'selected';
					}
					else{
						flag = '';
					}
					output+='<option value="'+result[i].catagory_name+'" '+flag+'>'+result[i].catagory_name+'</option>';
				}
				
				$('#select_catagory').html(output);
				
			}
		});
	}  
</script>
<script type="text/javascript">
$(document).ready(function() {
		$("#reset_btn").click(function(event) {
		event.preventDefault();
				$('#lock22').val('');
		});
	});
</script>
<script>
function checkAvailability() {
	$("#loaderIcon2").show();
	$.ajax({
	url: "<?php echo base_url();?>Product/check_barcode_1",
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
	url: "<?php echo base_url();?>Product/check_product_2",
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