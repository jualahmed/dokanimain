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
.content33{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 15px;
}
.content332{
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
    ~height: 285px;
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
	<?php
	$status = $this->uri->segment(4);
	if($status!='')
	{
		if($status=='successful')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Receipt Successfully Edited", ":)", "success")
					});
			</script>';
		}
		else if($status=='failed')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Something wrong with Receipt Edit", ":(", "info")
					});
			</script>';
		}
		else if($status=='exist')
		{
			echo '<script>
					$(document).ready(function(){
						swal("This Product is already been Exist", ":)", "info")
					});
			</script>';
		}
		/* else if($status=='error')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Something Wrong", ":(", "info")
					});
			</script>';
		} */
	}
?>
	<section class="content33" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"> Purchase Receipt Modify</h3>
					</div>
					<div class="box-body">
						<table class="table table-bordered reduce_space" >
							<tbody id="general_info">
								<tr>
									<td style="width: 15%;vertical-align: middle;">Receipt Modify</td>
									<td colspan="3">
										<?php
											//echo form_dropdown('product_id', $product_info, '' ,'class="dropdown"');
											echo form_dropdown('result', $purchase_receipt,'', 'class="select10" style="width:100%;" id="receipt_id"');
										?>
									</td>
								</tr>
							</tbody>
						</table>
						<br>
					<?php
					if($this -> uri -> segment(3))
					{
						foreach($receipt_general_details -> result() as $result):
					?>
							<table class="table table-bordered reduce_space" >
								<tbody id="general_info">
									<tr>
										<td style="width: 15%;vertical-align: middle;">Distributor Name</td>
										<td colspan="3">
											<?php echo  $result -> distributor_name;?>
										</td>
										<td style="width: 15%;vertical-align: middle;"> Receipt ID </td>
										<td colspan="3">
											<?php
												echo  $result -> receipt_id;
												
											?> 
										</td>
									</tr>
									<tr>
										<td style="width: 15%;vertical-align: middle;">Creator's Full Name</td>
										<td colspan="3">
											<?php echo  $result -> user_full_name;?>
										</td>
										<td style="width: 15%;vertical-align: middle;">
											Receipt Date 
										</td>
										<td colspan="3">
											<?php echo  $result -> receipt_date;?>
										</td>
									</tr>
								</tbody>
							</table>
						<br>
						<form action="<?php echo base_url();?>modify_controller/total_purchase_price_modify_apply" method="POST" class="form-horizontal">
							<table class="table table-bordered reduce_space">
								<tbody>
									<tr>
										<td style="vertical-align: middle;" colspan="2">
											Purchase Total
										</td>
										<td colspan="2">
											<?php 
												echo form_hidden('receipt_id' , $result -> receipt_id);
												echo form_input('purchase_amount', $result -> purchase_amount,'class="form-control custom_form_control" id="purchase_amount"  style="text-align:right;" placeholder="Purchase Total"');
											?>
										</td>
										<td style="vertical-align: middle;" colspan="2">
											Discount Amount
										</td>
										<td colspan="2">
											<?php 
												echo form_input('gift_on_purchase', $result -> gift_on_purchase,'class="form-control custom_form_control" maxlength="100" id="gift_on_purchase"  style="text-align:right;" placeholder="Discount Amount"');
											?>
										</td >
										<td style="vertical-align: middle;" colspan="2" >Transport Cost</td>
										<td colspan="2">
											<?php 
												echo form_input('new_transport_cost', $result -> transport_cost,'class="form-control custom_form_control" maxlength="100" id="five"  style="text-align:right;" placeholder="Transport Cost"');
											?>
										</td>
									</tr>
									<tr>
										<td style="vertical-align: middle;" colspan="2">Amount To Be Paid</td>
										<td colspan="4">
											<?php 
												echo form_input('new_grand_total', $result -> grand_total,'class="form-control grand_total custom_form_control" id="grand_total" placeholder="Grand Total"  style="text-align:right;" readonly');
											?>
										</td>
										<td style="vertical-align: middle;" colspan="2">
											Product List Total
										</td>
										<td  colspan="4">
											<?php 
												echo form_input('', $result -> total_listing,'class="form-control custom_form_control" maxlength="100" id="" placeholder="Product List Total" Readonly');
											?>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="box-footer" style="background: #0f77ab;">
								<center>
									<button type="submit" class="btn btn-success btn-sm" name="search_random" onclick="return confirm('Are you sure want to Update ?')" id="submit_btn"><i class="fa fa-fw fa-save"></i> Update</button>
								</center>
							</div>	
						</form>							
					</div> 
					<?php
					
					endforeach;
					}
					?>
				</div>
			</div>
		</div>
	</section>
	
</div>
<script>
 $('#purchase_amount').keyup(function()
 {
	var purchase_amount = $(this).val();
	var gift_on_purchase = $('#gift_on_purchase').val();
	if(isNaN(gift_on_purchase))
	{
		gift_on_purchase = 0;
	}
	else{
		gift_on_purchase = gift_on_purchase;
	}
	var avg_price = purchase_amount-gift_on_purchase;
	$('.grand_total').val(avg_price);
});
$('#gift_on_purchase').keyup(function()
{
	var gift_on_purchase = $(this).val();
	var purchase_amount = $('#purchase_amount').val();

	var avg_price = purchase_amount-gift_on_purchase;
	$('.grand_total').val(avg_price);
});

$(document).ready(function () 
{
	$('#receipt_id').on('change',function (evv) 
	{
		
		var receipt_id = $(this).val();
		var submiturl 	= '<?php echo base_url();?>modify_controller/total_purchase_price';
		window.open(submiturl+'/'+receipt_id);
	});
});
</script>
<?php $this -> load -> view('include/footer'); ?>




