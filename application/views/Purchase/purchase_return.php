<div class="content-wrapper">
<h1 class="text-center text-success">
	<?php
		$result = $this->uri->segment(3);
		if($result!='')if($result=='success') echo "Purchase Return Done...";
	?>
</h1>
	<input type="hidden" id="hide_dist" value="<?php echo $this->uri->segment(3);?>">
    <section class="content">
      <!-- Small boxes (Stat box) -->
        <div class="row">
       		<div class="col-md-6">
        		<div class="box">
            		<div class="box-header with-border" style="background: #0f77ab;">
              			<h3 class="box-title" style="color: #fff;">Purchase Return</h3>
            		</div>
            		<?php $stock_amount=0; ?>
             		<div class="box-body">
                		<div class="col-md-12">
							<table class="table table-bordered reduce_space" >
								<tr>
									<td style="width: 35%;vertical-align: middle;">Distributor:</td>
									<td>
										<select name="distributor_id" id="distributor_id" class="form-control">
											<option value="">Select a Distributor</option>
											<?php foreach ($distributor_info as $key => $var): ?>
												<?php if ($this->uri->segment(3)==$var->distributor_id): ?>
													<option selected value="<?php echo $var->distributor_id ?>"><?php echo $var->distributor_name ?></option>
												<?php else: ?>												
												<option value="<?php echo $var->distributor_id ?>"><?php echo $var->distributor_name ?></option>
												<?php endif ?>
											<?php endforeach ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="width: 35%;vertical-align: middle;">Product:</td>
									<td>
										<select class="form-control select2 sel_dist" name="product_id" id="product_id" style="width: 100%;" required>
											<option value="">Select Product</option>
											<?php
											if(count($product_info)>0)
											{
												foreach($product_info as $field)
												{ 
											?>	
												<?php if ($this->uri->segment(4)==$field->product_id): ?>
													<option selected value="<?php echo $field->product_id;?>"><?php echo $field->product_name;?></option>
												<?php else: ?>
													<option value="<?php echo $field->product_id;?>"><?php echo $field->product_name;?></option>
												<?php endif ?>
											<?php 
												}
											}
											?>
										</select>
									</td>
								</tr>
							</table>
							<form action="<?php echo base_url();?>purchase/list_purchase_temp_data" method="post" autocomplete="off">
								<input type="hidden" name="pro_id" required value="<?php echo $this->uri->segment(4);?>">
								<input type="hidden" name="dis_id" required value="<?php echo $this->uri->segment(3);?>">
								<?php
								if($this->uri->segment(4)!='')
								{
									if($product_info_warranty_details->num_rows()>0)
									{
									?>
									<table class="table table-bordered reduce_space" >
										<tr>
											<td colspan="4" style="text-align:center;background: #0f77ab;color: white;">Product Details</td>
										</tr>
										<?php
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
											<td><?php echo $tmp->bulk_unit_buy_price;?></td>
											<input type="hidden" name="buy_price" value="<?php echo $tmp->bulk_unit_buy_price;?>">
										</tr>
										<?php 
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
											$stock_amount=$tmp2->stock_amount;
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
										if($product_info_details->num_rows() > 0)
										{
										?>
										<table class="table table-bordered reduce_space" >
											<tr>
												<td colspan="4" style="text-align:center;background: #0f77ab;color: white;">Product Details</td>
											</tr>
											<?php
											foreach($product_info_details->result() as $tmp)
											{
											?>
											<tr>
												<td>Product Name</td>
												<td colspan="3"><?php echo $tmp->product_name;?></td>
											</tr>
											<tr>
												<td>Stock Amount</td>
												<td><?php echo $tmp->stock_amount; ?> <input type="hidden" id="stock_amount"  value="<?php echo $tmp->stock_amount ?>" name=""></td>
												<td>Buy Price</td>
												<td><?php echo $tmp->bulk_unit_buy_price;?></td>
												<input type="hidden" name="buy_price" value="<?php echo $tmp->bulk_unit_buy_price;?>">
											</tr>
											<?php
												if($tmp->stock_amount>0)
												{
												$stock_amount=$tmp->stock_amount;
												?>
													<tr>
														<td>Return Quantity</td>
														<td colspan="4"><input type="text" id="return_amount" name="return_amount" class="form-control"></td>
													</tr>
											<?php 
												}
												else
												{
											?>
													<tr>
														<td>Return Quantity</td>
														<td colspan="4"><input type="text" id="return_amount" title="Stock amount Is Not Available" name="return_amount" readonly class="form-control"></td>
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
											<?php if($this->uri->segment(4)!='' && $stock_amount>0){ ?>
												<button type="submit" id="d-block" class="btn btn-success btn-sm" name="search_random" id="submit"><i class="fa fa-fw fa-save" ></i> Create</button>

												<button type="submit" id="d-nodedsd" class="btn btn-success btn-sm" disabled name="search_random" id="submit"><i class="fa fa-fw fa-save" ></i> Create</button>
											<?php }else{ ?>
											<button type="submit" disabled class="btn btn-success btn-sm" name="search_random" id="submit"><i class="fa fa-fw fa-save"></i> Create</button>
											<?php } ?>
										</div>
									</center>
								</div>
							</form>
              			</div>
                	</div>
          		</div>
        	</div>
			<?php
			if($return_main_product->num_rows() > 0)
			{
			?>
			<div class="col-md-6">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Purchase Return List</h3>
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
									<td style="text-align:center;"><b>Distributor Name:</b> <?php echo $field->distributor_name;?></td>
								</tr>
							</table>
							<table class="table table-bordered reduce_space" >
								<tr>
									<td style="text-align:center;">No</td>
									<td style="text-align:center;">Product Name</td>
									<td style="text-align:center;">Quantity</td>
									<td style="text-align:center;"></td>
								</tr>
								<?php
								$i=1;
								$ii=1;
								foreach($return_main_product->result() as $tmp)
								{
								?>
								<tr>
									<td><?php echo $i;?></td>
									<td><b>Main Product:</b> <?php echo $tmp->product_name;?><br>
										<?php
										
										foreach($return_warranty_product[$ii]->result() as $new_tmp)
										{
											echo '<b>Warranty Product:</b> '.$new_tmp->sl_no.'<br>';

										}
										?>
									</td>
									<td style="text-align:center;"><?php echo $tmp->return_quantity;?></td>
									<td style="text-align:center;"><i id="delete<?php echo $tmp->prmp_id;?>" class="fa fa-fw fa-remove delete_product" style="color: red;cursor:pointer;" ></i> </td>
								</tr>
								<?php
									$ii++;
									$i++;
								}
								?>
							</table>
							<div class="box-footer" style="background: #0f77ab;">
								<center>
									<div class="col-sm-22">
										<form id="dddddddddddddddddddd" action="<?php echo base_url();?>purchase/final_purchase_return" method="post" target="_blank">
										<button type="submit" class="btn btn-success btn-sm" name="search_random" id="final_submit"><i class="fa fa-fw fa-save"></i> Final Submit</button>
										</form>
									</div>
								</center>
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
</div>
