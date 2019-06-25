<?php $this->load->view('include/header_for_new_sale'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
<?php
	$result = $this->uri->segment(7);
	if($result!='')
	{
		if($result=='success')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Sale Return Done", ":)", "success")
					});
			</script>';
		}
		if($result=='customer')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Select Valid Customer", ":)", "info")
					});
			</script>';
		}
	}
?>
	<input type="hidden" id="return_type" value="<?php echo $this->uri->segment(3);?>">
	<input type="hidden" id="invo_type" value="<?php echo $this->uri->segment(4);?>">
	<input type="hidden" id="in_id" value="<?php echo $this->uri->segment(5);?>">
	<input type="hidden" id="pro_id" value="<?php echo $this->uri->segment(6);?>">
    <section class="content">
      <!-- Small boxes (Stat box) -->
        <div class="row">
       		<div class="col-md-6">
        		<div class="box">
            		<div class="box-header with-border" style="background: #0f77ab;">
              			<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"> Sale Return</h3>
            		</div>
		            <!-- /.box-header -->
		            <!-- form start -->
             		<div class="box-body">
                		<div class="col-md-12">	
							<?php
							if($this->uri->segment(3)=='cash')
							{
							?>
							<table class="table table-bordered reduce_space" >
							<tr>
								<td style="vertical-align: middle;width: 25%;">Cash Return:</td>
								<td><input type="checkbox" checked class="s2" style="width: 100%;"></td>
								<td style="vertical-align: middle;width: 25%;">Return Aginst Sale:</td>
								<td><input type="checkbox" class="s3" style="width: 100%;"></td>
							</tr>
							</table>
							<?php
							}
							else if($this->uri->segment(3)=='productsale')
							{
							?>
							<table class="table table-bordered reduce_space" >
							<tr>
								<td style="vertical-align: middle;width: 25%;">Cash Return:</td>
								<td><input type="checkbox" class="s2" style="width: 100%;"></td>
								<td style="vertical-align: middle;width: 25%;">Return Aginst Sale:</td>
								<td><input type="checkbox" checked class="s3" style="width: 100%;"></td>
							</tr>
							</table>
							<?php
							}
							else
							{
							?>
							<table class="table table-bordered reduce_space" >
							<tr>
								<td style="vertical-align: middle;width: 25%;">Cash Return:</td>
								<td><input type="checkbox" class="s2" style="width: 100%;"></td>
								<td style="vertical-align: middle;width: 25%;">Return Aginst Sale:</td>
								<td><input type="checkbox" class="s3" style="width: 100%;"></td>
							</tr>
							</table>
							<?php
							}
							?>
							<table class="table table-bordered reduce_space" >
								<?php
								if($this->uri->segment(4)=='yes')
								{
								?>
								<tr>
									<td style="vertical-align: middle;width: 25%;">With Invoice:</td>
									<td>
										<input type="checkbox" checked class="select1" style="width: 25%;">
									</td>
									<td style="vertical-align: middle;width: 25%;">Without Invoice:</td>
									<td>
										<input type="checkbox" class="selectt222" style="width: 25%;">
									</td>
								</tr>
								<?php
								}
								else if ($this->uri->segment(4)=='no')
								{
								?>
								<tr>
									<td style="vertical-align: middle;width: 25%;">With Invoice:</td>
									<td>
										<input type="checkbox" class="select1" style="width: 25%;">
									</td>
									<td style="vertical-align: middle;width: 25%;">Without Invoice:</td>
									<td>
										<input type="checkbox" checked class="selectt222" style="width: 25%;">
									</td>
								</tr>
								<?php
								}
								else if ($this->uri->segment(3)!='')
								{
								?>
								<tr>
									<td style="vertical-align: middle;width: 25%;">With Invoice:</td>
									<td>
										<input type="checkbox" class="select1" style="width: 25%;">
									</td>
									<td style="vertical-align: middle;width: 25%;">Without Invoice:</td>
									<td>
										<input type="checkbox" class="selectt222" style="width: 25%;">
									</td>
								</tr>
								<?php
								}
								else if ($this->uri->segment(4)!='' && $this->uri->segment(4)!='null')
								{
								?>
								<tr>
									<td style="vertical-align: middle;width: 25%;">With Invoice:</td>
									<td>
										<input type="checkbox" class="select1" style="width: 25%;">
									</td>
									<td style="vertical-align: middle;width: 25%;">Without Invoice:</td>
									<td>
										<input type="checkbox" class="selectt222" style="width: 25%;">
									</td>
								</tr>
								<?php
								}
								?>
								
								<?php
								if($this->uri->segment(4)!='' && $this->uri->segment(4)!='null')
								{
								?>
									<tr>
										<td style="vertical-align: middle;">Invoice:</td>
										<td colspan="3">
											<?php
											if($this->uri->segment(4)=='yes')
											{
											?>
												<input type="number" name="invoice_id" required id="invoice_id" class="form-control" value="">
											<?php 
											}
											else
											{
											?>
												<input type="number" class="form-control" disabled>
											<?php 
											}
											?>
										</td>
									</tr>
									<tr>
										<td style="vertical-align: middle;">Product:</td>
										<td colspan="3">
											<select class="form-control select2 sel_dist" name="product_id" id="product_id" style="width: 100%;" required>
												<option value="">Select Product</option>
												<?php
												if($product_info->num_rows > 0)
												{
													foreach($product_info-> result() as $field)
													{ 
												?>
														<option value="<?php echo $field->product_id;?>"><?php echo $field -> product_name;?></option>
												<?php 
													}
												}
												?>
											</select>
										</td>
									</tr>
								<?php 
								}
								?>
							</table>
							<form action="<?php echo base_url();?>salereturn/list_cashsalereturn_temp_data" method="post" autocomplete="off">
								<input type="hidden" name="pro_id" value="<?php echo $this->uri->segment(6);?>">
								<input type="hidden" name="inv_id" value="<?php echo $this->uri->segment(5);?>">
								<input type="hidden" name="in_type" value="<?php echo $this->uri->segment(4);?>">
								<input type="hidden" name="ret_type" value="<?php echo $this->uri->segment(3);?>">
								<?php
								if($this->uri->segment(6)!='' && $this->uri->segment(6)!='null')
								{
									if($product_info_warranty_details->num_rows > 0)
									{
									?>
									<table class="table table-bordered reduce_space" >
										<tr>
											<td colspan="4" style="text-align:center;background: #0f77ab;color: white;">Product Details</td>
										</tr>
										<?php
										if($this->uri->segment(4)=='yes')
										{
											foreach($product_info_details->result() as $tmp)
											{
											?>
											<tr>
												<td>Product Name</td>
												<td colspan="3"><?php echo $tmp->product_name;?></td>
											</tr>
											<tr>
												<td>Sale Quantity</td>
												<td><?php echo $tmp->sale_quantity;?></td>
												<td>Discount Amount</td>
												<td><?php echo sprintf('%0.2f',$tmp->discount);?></td>
											</tr>
											<tr>
												<td>Product Price</td>
												<td><?php echo sprintf('%0.2f',$tmp->unit_sale_price);?></td>
												<td>Shop Price</td>
												<td><?php echo sprintf('%0.2f',$tmp->general_sale_price);?></td>
											</tr>
											<tr>
												<td>Exact Sale Price</td>
												<td colspan="4"><?php echo sprintf('%0.2f',$tmp->exact_sale_price);?></td>
												<input type="hidden" name="exact_price" value="<?php echo sprintf('%0.2f',$tmp->exact_sale_price);?>">
											</tr>
										<?php 
											}
										}
										else if($this->uri->segment(4)=='no')
										{
											foreach($product_info_details->result() as $tmp)
											{
											?>
											<tr>
												<td>Product Name</td>
												<td colspan="3"><?php echo $tmp->product_name;?></td>
											</tr>
											<tr>
												<td>Stock Amount</td>
												<td><?php echo $tmp->stock_amount;?></td>
												<td>Buy Price</td>
												<td><?php echo sprintf('%0.2f',$tmp->bulk_unit_buy_price);?></td>
											</tr>
											<tr>
												<td>Product Price</td>
												<td><?php echo sprintf('%0.2f',$tmp->bulk_unit_sale_price);?></td>
												<td>Shop Price</td>
												<td><?php echo sprintf('%0.2f',$tmp->general_unit_sale_price);?></td>
												<input type="hidden" name="exact_price" value="<?php echo sprintf('%0.2f',$tmp->general_unit_sale_price);?>">
											</tr>
										<?php 
											}
										}
										?>
									</table>
									<table class="table table-bordered reduce_space" >
										<tr>
											<td colspan="4" style="text-align:center;background: #0f77ab;color: white;">Warranty Product Details</td>
										</tr>
										<tr>
											<td style="text-align:center;">No</td>
											<td style="text-align:left;">Serial Name</td>
											<td style="text-align:center;">Action</td>
										</tr>
										<?php
										$i=1;
										foreach($product_info_warranty_details->result() as $tmp2)
										{
										?>
										<tr>
											<td style="text-align:center;"><?php echo $tmp2->ip_id;?></td>
											<td style="text-align:left;"><?php echo $tmp2->sl_no;?></td>
											<td style="text-align:center;"><input type="checkbox" name="ip_ids[<?php echo $i; ?>]" value="<?php echo $tmp2->ip_id; ?>" id="check_box"></td>
										</tr>
										<?php 
											$i++;
										}
										?>
									</table>
									<?php 
									}
									else
									{
									?>
										<?php
										if($product_info_details->num_rows > 0)
										{
										?>
										<table class="table table-bordered reduce_space" >
											<tr>
												<td colspan="4" style="text-align:center;background: #0f77ab;color: white;">Product Details</td>
											</tr>
											<?php
											if($this->uri->segment(4)=='yes')
											{
												foreach($product_info_details->result() as $tmp)
												{
												?>
												<tr>
													<td>Product Name</td>
													<td colspan="3"><?php echo $tmp->product_name;?></td>
												</tr>
												<tr>
													<td>Sale Quantity</td>
													<td><?php echo $tmp->sale_quantity;?></td>
													<td>Discount Amount</td>
													<td><?php echo sprintf('%0.2f',$tmp->discount);?></td>
												</tr>
												<tr>
													<td>Product Price</td>
													<td><?php echo sprintf('%0.2f',$tmp->unit_sale_price);?></td>
													<td>Shop Price</td>
													<td><?php echo sprintf('%0.2f',$tmp->general_sale_price);?></td>
												</tr>
												<tr>
													<td>Exact Sale Price</td>
													<td colspan="4"><?php echo sprintf('%0.2f',$tmp->exact_sale_price);?></td>
													<input type="hidden" name="exact_price" value="<?php echo sprintf('%0.2f',$tmp->exact_sale_price);?>">
												</tr>
												<tr>
													<td>Return Quantity</td>
													<td colspan="4"><input type="text" id="return_amount" name="return_amount" class="form-control"></td>
												</tr>
											<?php 
												}
											}
											else if($this->uri->segment(4)=='no')
											{
												foreach($product_info_details->result() as $tmp)
												{
												?>
												<tr>
													<td>Product Name</td>
													<td colspan="3"><?php echo $tmp->product_name;?></td>
												</tr>
												<tr>
													<td>Stock Amount</td>
													<td><?php echo $tmp->stock_amount;?></td>
													<td>Buy Price</td>
													<td><?php echo sprintf('%0.2f',$tmp->bulk_unit_buy_price);?></td>
												</tr>
												<tr>
													<td>Product Price</td>
													<td><?php echo sprintf('%0.2f',$tmp->bulk_unit_sale_price);?></td>
													<td>Shop Price</td>
													<td><?php echo sprintf('%0.2f',$tmp->general_unit_sale_price);?></td>
													<input type="hidden" name="exact_price" value="<?php echo sprintf('%0.2f',$tmp->general_unit_sale_price);?>">
												</tr>
												<tr>
													<td>Return Quantity</td>
													<td colspan="4"><input type="text" id="return_amount" name="return_amount" class="form-control"></td>
												</tr>
											<?php 
												}
											}
											?>
										</table>
									<?php
										}
									}
								}
								?>
								<div class="box-footer" style="background: #0f77ab;">
									<center>
										<div class="col-sm-22">
											<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit"><i class="fa fa-fw fa-save"></i> Create</button>
											<a href="<?php echo base_url();?>salereturn/cash_salereturn" class="btn btn-danger btn-sm" name="search_random" id="submit"><i class="fa fa-close"></i> Cancel</a>
										</div>
									</center>
								</div>
							</form>
              			</div>
                	</div>
          		</div>
        	</div>
			<?php
			if($this->uri->segment(8)!='')
			{
			?>
			<div class="col-md-6">
        		<div class="box">
            		<div class="box-header with-border" style="background: #0f77ab;">
              			<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"> Go to sale page</h3>
            		</div>
             		<div class="box-body">
						<center><a href="<?php echo base_url();?>sale_controller/new_active_sale_with_salereturn/<?php echo $this->uri->segment(8);?>" class="total_click" style="font-size: 30px;text-decoration: none;"><i class="fa fa-mail-forward"></i> Click Here</a></center>
					</div>
				</div>
			</div>
			<?php
			}
			if($return_main_product->num_rows > 0)
			{
			?>
			<div class="col-md-6">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Sale Return List</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<div class="box-body">
						<div class="col-md-12">
							<?php
								$field = $return_main_product->row();
							?>
							<table class="table table-bordered reduce_space" >
								<tr>
									<td style="text-align:center;"><b>Invoice ID:</b> <?php echo $field->inv_id;?></td>
								</tr>
							</table>
							<table class="table table-bordered reduce_space" >
								<tr>
									<td style="text-align:center;">No</td>
									<td style="text-align:center;">Product Name</td>
									<td style="text-align:center;">Quantity</td>
									<td style="text-align:center;">Price</td>
									<td style="text-align:center;">Total</td>
									<td style="text-align:center;"></td>
								</tr>
								<?php
								$i=1;
								$ii=1;
								$total_amount=0;
								foreach($return_main_product->result() as $tmp)
								{
								?>
								<tr>
									<td><?php echo $i;?></td>
									<td><b>Main:</b> <?php echo $tmp->product_name;?><br>
										<?php
										
										foreach($return_warranty_product[$ii]->result() as $new_tmp)
										{
											echo '<b>Warranty:</b> '.$new_tmp->sl_no.'<br>';

										}
										?>
									</td>
									<td style="text-align:center;"><?php echo $tmp->return_quantity;?></td>
									<td style="text-align:center;"><?php echo sprintf('%0.2f',$tmp->exact_price);?></td>
									<td style="text-align:center;"><?php echo sprintf('%0.2f',$tmp->return_quantity * $tmp->exact_price);?></td>
									<td style="text-align:center;"><i id="delete<?php echo $tmp->srmp_id;?>" class="fa fa-fw fa-remove delete_product" style="color: red;cursor:pointer;" ></i> </td>
								</tr>
								<?php
									$total_amount+=$tmp->return_quantity * $tmp->exact_price;
									$ii++;
									$i++;
								}
								?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td>Total Amount</td>
									<td style="text-align:center;" id="total_amount_return"><?php echo sprintf('%0.2f',$total_amount);?></td>
									<td></td>
								</tr>
								<form action="<?php echo base_url();?>salereturn/final_sale_return" method="post">
								<input type="hidden" name="in_id" value="<?php echo $this->uri->segment(5);?>">
								<input type="hidden" name="in_type" value="<?php echo $this->uri->segment(4);?>">
								<input type="hidden" name="re_type" value="<?php echo $this->uri->segment(3);?>">
								<tr>
									<td style="vertical-align: middle;">Customer <span>*</span></td>
									<td colspan="5">
										<select name="customer_id" id="customer_id" class="form-control select2" style="width:100%;" required="on">
											<option value="">Select Customer</option>
											<?php
											foreach ($customer_info->result_array() as $tmp)
											{
											?>
												<option value="<?php echo $tmp['customer_id'];?>"><?php echo $tmp['customer_name'];?> (<?php echo $tmp['customer_contact_no'];?>)</option>
											<?php
											}
											
											?>
										</select>
									</td>
								</tr>
								
							</table>
							<div id="all_sa_col" style="display:none;">
								<table class="table table-bordered remove_thead_space remove_tbody_space" id="sale_return_tbl">
									<thead>
										<tr class="bg-aqua color-palette">
											<td style="width: 16%;text-align: right;color:black;color: black;background: lightgray;">Sale</td>
											<td style="width: 14%;text-align: right;color:black;color: black;background: lightgray;">Collection</td>
											<td style="width: 16%;text-align: right;color:black;color: black;background: lightgray;">Sale Return</td>
											<td style="width: 16%;text-align: right;color:black;background: lightgray;">Due</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="text-align: right;"><span id="ledger_amount_sale"></span></td>
											<td style="text-align: right;"><span id="ledger_amount_collection"></span></td>
											<td style="text-align: right;"><span id="ledger_amount_sale_return"></span></td>
											<td style="text-align: right;"><span id="ledger_amount_balance"></span></td>
										</tr>
									</thead>
								</table>
							</div>
							<table class="table table-bordered remove_thead_space remove_tbody_space">
								<thead>
									<tr>
										<td style="width: 50%;color:black;">Total Return Adjustment</td>
										<td style="text-align: center;color:black;"><input type="text" class="form-control" id="return_adjustment_amount" name="return_adjustment_amount" style="width: 100%; border-radius: 0px;" placeholder="Total Return Adjustment" autocomplete="off" readonly></td>
									</tr>
								</thead>
							</table>
							<div class="box-footer" style="background: #0f77ab;">
								<center>
									<div class="col-sm-22">
										
										<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit"><i class="fa fa-fw fa-save"></i> Final Submit</button>
										
									</div>
								</center>
								</form>
							</div>
						</div>    
					</div>    
				</div>    
			</div>
			<?php
			}
			?>
      	</div>    
    </section>
    <!-- /.content -->
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets2/sweetalert2/sweetalert2.min.css">
<script type="text/javascript" src="<?php echo base_url();?>assets2/sweetalert2/sweetalert2.min.js"></script>
<script>
	function blinker() 
	{
		$('.total_click').fadeOut(500);
		$('.total_click').fadeIn(500);
	}
	setInterval(blinker, 1000);
	$(document).ready(function() 
	{

			$("input[type='checkbox'].s1").click(function() 
			{
				if ($(this).is(':checked')) 
				{
					$('.s2,.s3').not('.s1').removeAttr('checked');
					var submiturl 	= '<?php echo base_url();?>salereturn/cash_salereturn/product';
			
					window.open(submiturl,'_self');
				} 
				else 
				{
					$('.s2,.s3').removeAttr('checked');
				}
			});
			$("input[type='checkbox'].s2").click(function() 
			{
				if ($(this).is(':checked')) 
				{
					$('.s1,.s3').not('.s2').removeAttr('checked');
					var submiturl 	= '<?php echo base_url();?>salereturn/cash_salereturn/cash';
			
					window.open(submiturl,'_self');
				} 
				else 
				{
					$('.s1,.s3').removeAttr('checked');
				}
			});
			$("input[type='checkbox'].s3").click(function() 
			{
				if ($(this).is(':checked')) 
				{
					$('.s1,.s2').not('.s3').removeAttr('checked');
					var submiturl 	= '<?php echo base_url();?>salereturn/cash_salereturn/productsale';
			
					window.open(submiturl,'_self');
				} 
				else 
				{
					$('.s1,.s2').removeAttr('checked');
				}
			});
			$("input[type='checkbox'].select1").click(function() 
			{
				if ($(this).is(':checked')) 
				{
					$('.selectt222').not('.select1').removeAttr('checked');
					var return_type = $("#return_type").val();
					var submiturl 	= '<?php echo base_url();?>salereturn/cash_salereturn/'+return_type+'/yes';
			
					window.open(submiturl,'_self');
				} 
				else 
				{
					$('.selectt222').removeAttr('checked');
				}
			});
			$("input[type='checkbox'].selectt222").click(function() 
			{
				if ($(this).is(':checked')) 
				{
					$('.select1').not('.selectt222').removeAttr('checked');
					var return_type = $("#return_type").val();
					var submiturl 	= '<?php echo base_url();?>salereturn/cash_salereturn/'+return_type+'/no';
			
					window.open(submiturl,'_self');
				} 
				else 
				{
					$('.select1').removeAttr('checked');
				}
			});
			
		//$("#submit").prop("disabled", true);
		$("#invoice_id").on('keyup', function(ev)
		{
			ev.preventDefault();

			if(ev.which == 13)
			{
				var invoice_id = $(this).val();
				var return_type = $("#return_type").val();
				var invo_type = $("#invo_type").val();
				var submiturl 	= '<?php echo base_url();?>salereturn/cash_salereturn/'+return_type+'/'+invo_type+'/'+invoice_id;
				
				window.open(submiturl,'_self');
			}
		});
		$("#product_id").on("change",function()
		{
			var product_id = $(this).val();
			var return_type = $("#return_type").val();
			var invo_type = $('#invo_type').val();
			var invoice_id = $('#in_id').val();
			if(invoice_id==''){
				invoice_id='null';
			}
			else{
				invoice_id=invoice_id;
			}
			var submiturl 	= '<?php echo base_url();?>salereturn/cash_salereturn/'+return_type+'/'+invo_type+'/'+invoice_id+'/'+product_id;
			
			window.open(submiturl,'_self');
		});
		$("#return_amount").keyup(function()
		{
			var length=$("#return_amount").val().length;
			if(length>=1)
			{
				$("#submit").prop("disabled", false);
			}
			else
			{
				$("#submit").prop("disabled", true);
			}
		});
		/* $("#check_box").click(function()
		{
			if ($(this).is(':checked')) 
			{
				$("#submit").prop("disabled", false);
			}
			else
			{
				$("#submit").prop("disabled", true);
			}
		}); */
		$('.delete_product').click(function(){
			var edit_id 		= $(this).attr('id');
			var kval 			= edit_id.substring(6,10000000000000000000000000000000);
			swal({
				title               : 'Are you sure?',
				text                : "You won't be able to revert this!",
				type                : 'warning',
				showCancelButton    : true,
				confirmButtonColor  : '#db8b0b',
				cancelButtonColor   : '#419641',
				confirmButtonText   : 'Yes',
				cancelButtonText    : 'No'
			}).then(function () {

				$.ajax({
					url     : '<?php echo base_url()?>salereturn/removeProduct',
					type    : "POST",
					cache   : false,
					data    : { srmp_id: kval},
					success : function(result){
						swal(
						  'Deleted!',
						  'Data Delete Successfully..!)',
						  'success'
						);
						//thisTr.remove();	
						location.reload();
					}

				});
			})
		});
		
		$("#customer_id").on("change",function()
		{
			var urlx='<?php echo base_url();?>salereturn/get_customer_transaction';
			var customer_id=$(this).val();
			var outputs='';
			$.ajax
			({
				url: urlx,
				type: 'POST',
				dataType: 'json',
				data: {'customer_id':customer_id},
				success:function(result)
				{
					
					for(var ii=0; ii<result['balance'].length; ii++)
					{
						var balance_amount = parseFloat(result['balance'][ii].balance_amount);
						var customer_name = result['balance'][ii].customer_name;
						var customer_id = result['balance'][ii].customer_id;
						
					}
					for(var ii=0; ii<result['sale'].length; ii++)
					{
						var sale_amount = parseFloat(result['sale'][ii].sale_amount);
						
					}
					
					for(var ii=0; ii<result['sale_return'].length; ii++)
					{
						var sale_retrun_amount = parseFloat(result['sale_return'][ii].sale_retrun_amount);
						
					}

					if(isNaN(balance_amount))
					{
						balance_amount =0;
					}
					if(isNaN(sale_amount))
					{
						sale_amount =0;
					}
					if(isNaN(sale_retrun_amount))
					{
						sale_retrun_amount =0;
					}

					$('#all_sa_col').show();
					$("#ledger_amount_sale").html(parseFloat(sale_amount).toFixed(2));
					$("#ledger_amount_collection").html(parseFloat(balance_amount).toFixed(2));
					$("#ledger_amount_sale_return").html(parseFloat(sale_retrun_amount).toFixed(2));
					var totbalac = parseFloat(balance_amount) + parseFloat(sale_retrun_amount);

					$("#ledger_amount_balance").html(parseFloat(sale_amount - totbalac).toFixed(2)); 
					var tot_return_price = $('#total_amount_return').html();
					var tot_return_balance_price = $('#ledger_amount_balance').html();
					if(tot_return_price > tot_return_balance_price)
					{
						var return_adjustment_amount = parseFloat(tot_return_price) - parseFloat(tot_return_balance_price);
					}
					else if(tot_return_balance_price >= tot_return_price)
					{
						var return_adjustment_amount = 0;
					}
					
					$('#return_adjustment_amount').val(return_adjustment_amount);
				},
			});	
		});
	});
</script>


<?php $this -> load -> view('include/footer'); ?>