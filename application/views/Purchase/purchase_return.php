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
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"><button type="button" class="btn btn-primary" id="purchase_return"><i class="fa fa-spinner fa-spin" id="spin" style="display:none;"> </i> Start Purchase Return</button></h3>
					</div>
					<form id="purchase_return_from">
						<div class="box-body">
							<div class="input-form">
								<div class="col-md-4">
									<?php 
										echo form_dropdown('distributor_id', $distributor_info, '','class="form-control select11 pull-left distributor_idd" style="width: 100%;" id="distributor_id" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<div class="col-md-6">
									<input type="text" class="form-control" id="search_by_name" placeholder="Search By Product Name" style="width: 100%;border-radius: 0px; " autofocus="on">
								</div>
								<div class="col-md-2">
									<input type="text" class="form-control" data-toggle="tooltip" style="width: 100%; border-radius: 0px; text-align: center;" id="purchase_re_qnty" placeholder="Qnty">
								</div>
							</div>
							<br>
							<br>
							<table class="table table-bordered remove_thead_space remove_tbody_space" id="purchase_return_tbl">
								<thead>
									<tr class="bg-aqua color-palette">
										<td style="width: 30%;color:black;">Distirbutor</td>
										<td style="width: 40%;color:black;">Product</td>
										<td style="text-align: center;color:black;">Quty</td>
										<td style="text-align: center;color:black;">Price</td>
										<td style="text-align: center;color:black;">Total</td>
										<td style="text-align: center;color:black;"> <i class="fa fa-fw fa-wrench"></i> </td>
									</tr>
								</thead>
								<tbody id="purchase_return_list">
									<?php if($purchase_return_info != FALSE){ foreach($purchase_return_info->result() as $tmp){ ?>
									<tr>
										<td><?php echo $tmp->distributor_name; ?></td>
										<td><?php echo $tmp->product_name; ?></td>
										<td style="text-align: center;"><?php echo $tmp->return_quantity;?></td>
										<td style="text-align: right;"><?php echo $tmp->unit_buy_price;?></td>
										<td style="text-align: right;"><?php echo $tmp->total_price;?></td>
										<td id="<?php echo $tmp->product_id; ?>" name="dlt_btn" style="text-align: center; color: red;"> 
											<i class="fa fa-fw fa-remove renove_btn"></i> 
										</td>
									</tr>
									<?php }}?>
								</tbody>
							</table>
	              
							<input type="hidden" id="pur_re_pro_id">
							<input type="hidden" id="pur_re_pro_name">
							<input type="hidden" id="pur_re_pro_pric">
							<input type="hidden" id="">
							<input type="hidden" id="direct_return" value="<?php echo $tmp_purchase_return_id;?>">
							<input type="hidden" id="distributor_id_return" value="<?php echo $distributor_id;?>">
							<div class="box-footer" style="background: #0f77ab;">
								<center>
									<div class="col-sm-22">
										<button type="button" class="btn btn-success btn-sm" name="search_random" id="purchase_return_submit"><i class="fa fa-fw fa-save"></i> Create</button>
										<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									</div>
								</center>
							</div>
							
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-1.12.4.js"></script>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-ui.js"></script>
<script type="text/javascript">
	$(document).ready(function()
	{
		var id = $('#direct_return').val();
		if(id == '')
		{
			swal(
			'Oops...!',
			'Please Click on Purhcase Return Button!',
			'info'
			);
			
			$(".distributor_idd").prop("disabled", true);
			$("#search_by_name").prop("disabled", true);
			$("#purchase_re_qnty").prop("disabled", true);
		}
		else
		{
			$('#spin').show();
			
			$(".distributor_idd").prop("disabled", false);
			$("#search_by_name").prop("disabled", false);
			$("#purchase_re_qnty").prop("disabled", false);
		}
		$('#purchase_return').on('click', function()
		{
			var id = $('#direct_return').val();
			if(id == '')
			{
				$.ajax
				({
					url     : '<?php echo base_url();?>purchase/createPurchaseReturn_direct',
					type    : "POST",
					data    : {tmp_purchase_id: id},
					success : function(result)
					{
						$('#direct_return').val(result)
						$('#spin').show();
						$(".distributor_idd").prop("disabled", false);
						$("#search_by_name").prop("disabled", false);
						$("#purchase_re_qnty").prop("disabled", false);
					}
				});
			}
			else
			{
				swal(
				'Oops...!',
				'Please Click on Purchase Return Button!',
				'info'
				);
				$(".distributor_idd").prop("disabled", true);
				$("#search_by_name").prop("disabled", true);
				$("#purchase_re_qnty").prop("disabled", true);
			}
		});
		
		$(".distributor_idd").on("change",function()
		{
			var distributor_id_select=$(this).val();
			var distributor_id_return=$('#distributor_id_return').val();
			if(distributor_id_return!=0 && distributor_id_select!=distributor_id_return){
				swal(
				'Oops...!',
				'You Select Wrong Distributor!',
				'info'
				);
				$('.distributor_idd').val('');
				$('.distributor_idd').select11();
			}

		});

		$('#purchase_re_qnty').on('keydown', function(e)
		{
			if(e.keyCode == 13)
			{
				var pro_id 			= $('#pur_re_pro_id').val();
				var pro_name 		= $('#pur_re_pro_name').val();
				var unit_price 		= parseFloat($('#pur_re_pro_pric').val());
				var qnty 			= parseFloat($('#purchase_re_qnty').val());
				var distributor_id 	= $('#distributor_id').val();
				if(qnty != '' && !isNaN(qnty) && qnty > 0 && pro_name != '' && pro_id != '' && unit_price != '' && distributor_id != '')
				{
					$.ajax({
						url 	: '<?php echo base_url();?>purchase/addToPurchaseReturn',
						type 	: 'POST',
						data 	: {pro_id: pro_id, pro_name: pro_name, unit_price: unit_price, qnty: qnty, distributor_id: distributor_id},
						success : function(data)
						{
							$('#purchase_return_list').last().append(data);
							$('#purchase_re_qnty').val('');
							$('#sal_re_pro_id').val('');
							$('#sal_re_pro_name').val('');
							$('#sal_re_pro_pric').val('');
							$('#search_by_name').val('');
							$('#search_by_name').focus();
						}
					});
				}
				else
				{
					/* swal(
					'Oops...!',
					'Data missing!',
					'info'
					) */
					alert('Data missing!');
				}
			}
		});

		/*start*/
		$('#purchase_return_submit').on('click', function()
		{
			if(confirm('Are you sure?'))
			{
				var distributor_id 	= $('#distributor_id').val();
				if(distributor_id!='')
				{
					//alert('ok');
					$.ajax({
					  url     : '<?php echo base_url();?>purchase/doPurchaseReturn',
					  type    : "POST",
					  data 	: {distributor_id: distributor_id},
					  success : function(result)
					  {
						location.reload(); 
						window.open("<?php echo base_url()?>New_invoice_print/purchase_return/" + result, '_blank');      
						$('#purchase_re_qnty').val('');
						$('#sal_re_pro_id').val('');
						$('#sal_re_pro_name').val('');
						$('#sal_re_pro_pric').val('');
						$('#search_by_name').val('');
						$('#search_by_name').focus();
					  }
				  });
				}
				else{
					 swal(
					'Oops...!',
					'Please Select Distributor!',
					'info'
					);
					//alert('Please Select Distributor!');
				}
			}

		});
	  /*end*/

	  $('#purchase_return_tbl').on('click', "[name='dlt_btn']" ,function(){
		var selected_tr 	= $(this);
		var pro_id 			= selected_tr.attr('id');
		alert(pro_id);
		swal({
			title 				: 'Are You Sure?', 
			text 				: ':)',
			type 				: 'warning',
			showCancelButton 	: true,
			confirmButtonColor 	: '#db8b0b',
			cancelButtonColor 	: '#419641'
			}).then(function(){
				$.ajax({
					url  		: '<?php echo base_url();?>purchase/deleteProductFromPurchaseReturn',
					type 		: 'POST',
					data 		: {pro_id: pro_id},
					success 	: function(result)
					{
						selected_tr.closest('tr').hide();
						swal
						(
							'Deleted!',
							':)',
							'success'
						)
					}
				});
			});
		});
	});
		 $( "#search_by_name" ).autocomplete({
		  source  : function( request, response ){
			$.ajax({
			  url       : "<?php echo base_url();?>product_controller/searchProduct_2",
			  dataType  : "json",
			  cash    	: false,
			  type      : 'POST',
			  data      : {
						  term  : request.term,
						  flag  : 1
			  },
			  success: function( data ){
				response( $.map(data, function(item){
				  return{
					id              : item.id,
					label           : item.name,
					catagory_name   : item.catagory_name,
					company_name    : item.company_name,
					group_name      : item.group_name,
					bulk_unit_buy_price 		: item.bulk_unit_buy_price,
					unit_buy_price 				: item.unit_buy_price,
					bulk_unit_sale_price 		: item.bulk_unit_sale_price,
					general_unit_sale_price 	: item.general_unit_sale_price
					
				  }
				}));
			  }
			});
		  },
		  minLength: 3,
		  select: function( event, ui )
		  {
			var unit_buy_price          = parseFloat(ui.item.bulk_unit_buy_price);
			var unit_buy_price_purchase = parseFloat(ui.item.unit_buy_price);
			var general_sale_price      = parseFloat(ui.item.bulk_unit_sale_price);
			var exclusive_sale_price    = parseFloat(ui.item.general_unit_sale_price);
			
			$('#pur_re_pro_pric').val(unit_buy_price);
			$('#pur_re_pro_name').val(ui.item.label);
			$('#pur_re_pro_id').val(ui.item.id);
			$('#purchase_re_qnty').focus();

		  }
		}).autocomplete('widget').addClass('css_for_search_by_name');
</script>
<?php $this -> load -> view('include/footer'); ?>