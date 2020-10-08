<?php $this->load->view('include/header'); ?>
<link rel="stylesheet" href="<?php echo base_url();?>style/bootstrap-float-label.min.css"/>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<style type="text/css">
	table.remove_thead_space thead tr td{ padding: 2px; }
	table.remove_tbody_space tbody tr td{ padding: 2px; }
	.full-width{ width: 100%; }

	.control_select2
	{
		padding 	: 0px;
		margin 		: 0px;
		height 		: 24px;
	}
	
	.style{
		 width:87px;
	}
		 height:55px;
	
.wrap 
{
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap table {
    width: 100%;
    table-layout: fixed;
}
.wrap-1 {
	margin:-8px 0px 0px 0px;
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
.new_data_2 {
    width: 100%;
}
table tr td {
    padding: 5px;
    border: 1.5px solid #e1e1e1;
    ~width: 100%;
    word-wrap: break-word;
	background: white;
}
table.head tr td {
    color:white;
	background: #00c0ef;
	font-size:14px;
	font-family:Sans Pro; 
	font-weight:bold;
}

.new_data_2 tr:nth-child(even) td {
    background-color: #f4f4f4;
}
.new_data_2 tr:nth-child(odd) td {
    background-color: #fff;
}
.inner_table {
	color:#666768;
    height: 330px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}

.inner_table22 {
	color:#666768;
    height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table_2 {
	color:#403e3e;
    height: 33px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table::-webkit-scrollbar {
    width: 1px;
	background-color: #00c0ef;
}

.inner_table::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: white;
}

.inner_table::-webkit-scrollbar-thumb {
   background-color: #00c0ef;
   background-image: -webkit-linear-gradient(45deg,rgba(255, 255, 255, .2) 25%,transparent 25%,transparent 50%,rgba(255, 255, 255, .2) 50%,rgba(255, 255, 255, .2) 75%,transparent 75%,transparent)

}

</style>
<style>
	.content2{
		min-height: 130px;
		padding: 4px;
	}
</style>
<div class="content-wrapper">
	<section class="content2">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Product Exchange</h3>
					</div>
						<div class="box-body">
							<div class="input-form">
								<select class="form-control select22 pull-left" id="status_type" style="width: 29%;"tabindex="-1" aria-hidden="true">
									<option value="#">Select Type</option>
									<option value="Exchange">Exchange</option>
									<option value="Receive">Receive</option>
								</select>
								<select class="form-control select22 pull-left" id="productt_id" style="width: 60%;"tabindex="-1" aria-hidden="true" required="required">
									<option value="#">Select Product</option>
									<?php
									if($product_info!='')
									{
										foreach($product_info->result_array() as $tmp)
										{
										?>
											<option value="<?php echo $tmp['product_id'];?>"><?php echo $tmp['product_name'];?></option>
										<?php
										}
									}
									?>
								</select>
								<input type="text" class="form-control pull-right" data-toggle="tooltip" style="width: 10%; border-radius: 0px; text-align: center;" id="exchange_quantity" placeholder="Qnty">
								
							</div>
							<br>
							<table class="table table-bordered remove_thead_space remove_tbody_space" id="exchange_return_tbl">
								<thead>
									<tr class="bg-aqua color-palette">
										<td style="width: 50%;color:black;">Name</td>
										<td style="text-align: center;color:black;">Quty</td>
										<td style="text-align: center;color:black;">Price</td>
										<td style="text-align: center;color:black;">Total</td>
										<td style="text-align: center;color:black;">Status</td>
										<td style="text-align: center;color:black;"> <i class="fa fa-fw fa-wrench"></i> </td>
									</tr>
								</thead>
								<tbody id="exchange_return_list">
									<?php if($exchange_info != FALSE){ foreach($exchange_info->result() as $tmp){ ?>
									<tr>
										<td><?php echo $tmp->product_name; ?></td>
										<td style="text-align: center;"><?php echo $tmp->exchange_quantity;?></td>
										<td style="text-align: right;"><?php echo $tmp->unit_price;?></td>
										<td style="text-align: right;"><?php echo $tmp->exchange_quantity * $tmp->unit_price;?></td>
										<td style="text-align: center;"><?php echo $tmp->status1;?></td>
										<td id="<?php echo $tmp->product_id; ?>" name="dlt_btn" style="text-align: center; color: red;"> 
											<i class="fa fa-fw fa-remove renove_btn"></i> 
										</td>
									</tr>
									<?php }}?>
								</tbody>
							</table>
	              
							<input type="hidden" id="sal_re_pro_id">
							<input type="hidden" id="sal_re_pro_name">
							<input type="hidden" id="sal_re_pro_pric">
							<input type="hidden" id="">
							<div class="box-footer" style="background: #0f77ab;">
								<center>
									<div class="col-sm-22">
										<button type="button" class="btn btn-success btn-sm" name="search_random" id="sale_return_submit"><i class="fa fa-fw fa-save"></i> Confirm Exchange</button>
									</div>
								</center>
							</div>
							
						</div>
				</div>
			</div>
		</div>
	</section>
</div>
<script type="text/javascript">
	$(document).ready(function()
	{
		$('#exchange_quantity').on('keydown', function(e)
		{

			if(e.keyCode == 13)
			{
				var pro_id 			= $('#sal_re_pro_id').val();
				var pro_name 		= $('#sal_re_pro_name').val();
				var status_type 	= $('#status_type').val();
				var unit_price 		= parseFloat($('#sal_re_pro_pric').val());
				var qnty 			= parseFloat($('#exchange_quantity').val());
				if(status_type=='')
				{
					 alert('Select Type');
				}
				else
				{
					//if(qnty != '' && !isNaN(qnty) && qnty > 0 && pro_name != '' && pro_id != '' && unit_price != '')
					//{
						 $.ajax({
							url 	: '<?php echo base_url();?>exchange/addToExchangeReturn',
							type 	: 'POST',
							data 	: {pro_id: pro_id, pro_name: pro_name,status_type: status_type, unit_price: unit_price, qnty: qnty},
							success : function(data)
							{
								$('#exchange_return_list').last().append(data);
								$('#exchange_quantity').val('');
								$('#sal_re_pro_id').val('');
								$('#sal_re_pro_name').val('');
								$('#sal_re_pro_pric').val('');
							}
						});
					//}
				}
			}
		});

		/*start*/
		$('#sale_return_submit').on('click', function()
		{
			if(confirm('Are you sure?'))
			{
			  $.ajax({
				  url     : '<?php echo base_url();?>exchange/doExchangeReturn',
				  type    : "POST",
				  success : function(result)
				  {
					location.reload(); 
				  }
			  });
			}

		});
	  /*end*/

	  $('#cancel_sale_return').on('click', function(){
		  
		  if(confirm('Are you sure?')){
			$.ajax({
				url 		: '<?php echo base_url();?>sale_controller/cancelSaleReturn',
				success 	: function(){
					$('#sale_return_modal').modal('hide');
					$('#sale_return_list').empty();
					$('#return_adjust').val("");
					$('#sal_re_pro_id').val('');
					$('#sal_re_pro_name').val('');
					$('#sal_re_pro_pric').val('');
					$('#searchByProductName').focus();
				}
			});
		  }

	  });

	  $('#exchange_return_list').on('click', "[name='dlt_btn']" ,function(){
		var selected_tr 	= $(this);
		var pro_id 			= selected_tr.attr('id');
		swal({
			title 				: 'Are You Sure?', 
			text 				: ':)',
			type 				: 'warning',
			showCancelButton 	: true,
			confirmButtonColor 	: '#db8b0b',
			cancelButtonColor 	: '#419641'
			}).then(function(){
				$.ajax({
					url  		: '<?php echo base_url();?>exchange/deleteExchangeReturn',
					type 		: 'POST',
					data 		: {pro_id: pro_id},
					success 	: function(result)
					{
						selected_tr.closest('tr').hide();
						swal('Deleted!',
							':)',
							'success'
						)
					}
				});
			});
		});
	});
	
	$(document).ready(function()
	{
		$("#productt_id").on("change",function()
		{
			var urlx='<?php echo base_url();?>sale_controller/get_product_list2';
			var productt_id=$(this).val();
			//var invoice_id=$('#searchByInvoice').val();
			var outputs='';
			$.ajax
			({
				url: urlx,
				type: 'POST',
				dataType: 'json',
				data: {'product_id':productt_id},
				success:function(result)
				{
					
					var general_unit_sale_price =parseFloat(Math.round(result.general_unit_sale_price));
					$('#sal_re_pro_id').val(result.product_id);
					$('#sale_quantity').val(result.stock_amount);
					$('#sal_re_pro_name').val(result.product_name);
					$('#sal_re_pro_pric').val(general_unit_sale_price);
					
					$("#exchange_quantity").focus();  
				},
			});	
		});
	});
</script>
<?php $this -> load -> view('include/footer'); ?>