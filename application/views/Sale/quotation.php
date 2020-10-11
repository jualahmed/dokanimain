<?php 
	$this->load->config('custom_config'); 
	$value_added_tax = $this->config->item('VAT');
	$allow_negative_stock = $this->config->item('allow_negative_stock');
	$tp_price_purchase = $this->config->item('tp_price_purchase');
	$tp_price_vat_purchase = $this->config->item('tp_price_vat_purchase');
	$discount_limit = $this->config->item('discount_limit');
	$product_sale_return = $this->config->item('product_sale_return');
?>
<div class="content-wrapper">
<style type="text/css">
	.sale_table_custom_styl tbody tr td {
		padding: 2px 5px !important;
		font-size: 12px;
	}
	.box table .form-control {
		height: 25px;
		padding: 0px 2px;
		font-size: 12px;
		border-radius: 0px;
		border: none !important;
	}
	.btn-y-0 {
		padding: 0px 12px;
	}
</style>
	<section class="content">	
		<input type="hidden" id="allow_negative_stock" value="<?php echo $allow_negative_stock; ?>">
		<input type="hidden" id="value_added_tax" value="<?php echo $value_added_tax; ?>">
		<input type="hidden" id="discount_limit" value="<?php echo $discount_limit; ?>">

		<br>
		<div class="row">
			<div class="col-md-6">
				<div class="box box-info" style="margin-bottom: 0px;">
		           	<div class="box-body">
	                 	<table width="100%">
	                 		<tr>
	                 			<td width="40%" style="padding: 0px 2px;">
	                 				<input type="text" class="form-control search" id="search_by_product_name" placeholder="Search Product" autofocus="on">
	                 			</td>
								<td width="40%" style="padding: 0px 2px;">
	                 				<input type="text" class="form-control search" id="search_by_warran_product_model" placeholder="Search Product by serial">
	                 			</td>
								<td width="20%" style="padding: 0px 2px;">
	                 				<input type="text" class="form-control quantity" id="product_quantity" placeholder="Quantity" >
	                 			</td>
	                 		</tr>
	                 	</table>
						<input type="hidden" name="temp_pro_id" id="temp_pro_id" />
	                 	<input type="hidden" name="temp_pro_data" id="temp_pro_data" />
		            	<input type="hidden" name="temp_pro_qty" id="temp_pro_qty" />
		                <input type="hidden" name="pro_name" id="pro_name" />
		            	<input type="hidden" name="price" id="price" />
		            	<input type="hidden" name="mrp_price" id="buy_price_check"/>
		            	<input type="hidden" id="new_mrp_price" />
						<input type="hidden" name="mrp_price" id="mrp_price"/>
		            	<input type="hidden" id="buy_price" />
		            	<input type="hidden" id="sale_price" />
						<input type="hidden" id="product_specification" >
							<table class="table table-bordered sale_table_custom_styl">
			                <tr>
			                  <td style="width: 23%; vertical-align: middle;">No of Product(s): </td>
			                  <td colspan="2">
			                  	<input type="text" class="form-control sale_input_custom_styl align_right" id="number_of_products" placeholder="No of Product(s):" disabled="">
			                  </td>
			                  <td style="width: 20%; vertical-align: middle;">
			                  	Discount:
			                  </td>
			                  <td>
			                  	<input type="text" class="form-control sale_input_custom_styl align_right" id="disc_in_p" style="text-align: right;" placeholder="%">
			                  </td>
			                  <td>
			                  	<input type="text" class="form-control sale_input_custom_styl align_right" id="disc_in_f" style="text-align: right;"  placeholder="Taka">
			                  </td>
			                </tr>
			                <tr>
			                  <td style="vertical-align: middle;">VAT: </td>
			                  <td colspan="2">
			                    <input type="text" class="form-control sale_input_custom_styl align_right" id="vat" placeholder="VAT in %" disabled="">
			                  </td>
								<td style="vertical-align: middle;">
								Received:
								</td>
								<td colspan="2">
									<input type="text" class="form-control sale_input_custom_styl align_right" id="received" placeholder="Received">
								</td>
			                </tr>
			                <tr>
			                  <td style="vertical-align: middle;">Discount Amount: </td>
			                  <td colspan="2">
			                    <input type="text" class="form-control sale_input_custom_styl align_right" id="disc_amount" placeholder="Disc Amount" disabled="">
			                  </td>
			                  <td style="vertical-align: middle;">Return Adjust: </td>
			                  <td colspan="2">
			                    <input type="text" class="form-control sale_input_custom_styl align_right" id="return_adjust" placeholder="Return Adjust" disabled="on">
			                  </td>
			                </tr>
			                <tr>
			                  <td style="vertical-align: middle;">Sub-total: </td>
			                  <td colspan="2">
			                    <input type="text" class="form-control sale_input_custom_styl align_right" id="sub_total" placeholder="Sub-total" disabled="">
			                  </td>
							  <td style="vertical-align: middle;">Delivery Charge: </td>
			                  <td colspan="2">
			                    <input type="text" class="form-control sale_input_custom_styl align_right" id="delivery_charge" placeholder="Delivery Charge">
			                  </td>
			                </tr>
			                <tr>
			                  <td style="vertical-align: middle;">Total: </td>
			                  <td colspan="5">
			                    <input type="text" class="form-control sale_input_custom_styl align_right" id="total" placeholder="Total" disabled="">
			                  </td>
			                </tr>
			                <tr>
			                  <td style="vertical-align: middle;">Change: </td>
			                  <td colspan="5">
			                    <input type="text" class="form-control sale_input_custom_styl align_right" id="change" placeholder="Change" disabled="">
			                  </td>
			                </tr>
			                <tr>
			                  <td style="vertical-align: middle;">Payable: </td>
			                  <td colspan="5">
			                    <input type="text" class="form-control sale_input_custom_styl align_right" id="payable" placeholder="Payable" disabled="">
			                  </td>
			                </tr>
			                <tr>
			                  <td colspan="6">
			                    <input type="text" class="form-control sale_input_custom_styl" id="inword" style="text-align: center;"  placeholder="In Word" disabled="">
			                  </td>
			                </tr>
			                <tr>
			                  <td style="vertical-align: middle;">Customer: </td>
			                  <td colspan="5">
								<div class="input-group" style="width: 100%">
									<?php	
											if($current_sale_customer->num_rows > 0)
											{
												$customer_id=$query->customer_id;
												$customer_name=$query->customer_name;
										?>
										<input type="hidden" id="selected_customer_id" value="<?php echo $customer_id; ?>">
										<input type="text" class="form-control search" value="<?php echo $customer_name; ?>" id="search_by_customer_name" placeholder="Search Product" autofocus="on">
										<?php
											}
											else
											{
										?>
										<input type="hidden" id="selected_customer_id">
										<input type="text" class="form-control search" value="" id="search_by_customer_name" placeholder="Search Customer" autofocus="on">

										<?php
											}
										?>
									<div class="input-group-addon" style="padding-right: 0;border: none;">
									<button type="button" class="btn btn-info pull-right btn-y-0" data-toggle="modal" data-target="#exampleModal">+</button>
									</div>
								</div>
								
			                </tr>
	          			</table>
	          		</div>
		        </div>
				<div class="box-footer">
	      			<div style="display: flex;text-align: center;justify-content: space-around;">
						<div>
							<button type="button" class="btn btn-primary btn_for_sale style" id="quotation">Quotation </button>
						</div>
						<div>
							<button type="button" class="btn btn-danger btn_for_sale style" id="cancel">Cancel <span>(Alt+X)</span></button>
						</div>

					</div>
	  			</div>
			</div>

			<!-- listing all product -->
			<style>
			#selected_product_list_tbl tr {
				font-size: 12px;
			} 
			 #selected_product_list_tbl th, 
			 #selected_product_list_tbl td {
				padding: 2px 5px!important;
			 }
			</style>
			<div class="col-md-6">
				<table class="table" id="selected_product_list_tbl">
              		<tr class="bg-aqua color-palette">
              			<td>
              				SL
              			</td>
						<td style="white-space: normal!important;" width="30%">
              				Product Name
              			</td>
              			<td style="text-align: center;">
              				Stock
              			</td>
              			<td style="text-align: center;">
              				Qty.
              			</td>
						<td style="text-align: right;">
              				Unite Price
              			</td>
              			<td style="text-align: right;">
              				Total Price
              			</td>
              			<td style="text-align: center;">
              				 <i class="fa fa-fw fa-wrench"></i>
              			</td>
              		</tr>
			
					  <?php 
					  $qnty = 0;
					  $total_sale = 0;
					  $total_buy_price = 0;
					  $total_profit = 0;
					  $total_sale_price = 0;
					  $final_profit_percent = 0; 
					  $buy_price = 0;
					  $sale_price = 0;
					  $profit = 0;
					  $profit_percent = 0; 
					  $total_qnty = 0; 
					  $sub_to = 0; 
					  $vat = 0; 
					  $ind = 1;
					?>
        			<?php 
        				if($tmp_item)
        				{ 
        					$i_num = 1;
							foreach($tmp_item->result() as $tmp)
        					{
        			?>
								<tr style="background-color: white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;    font-weight: 500;">
									<td id="pro_name"><?php echo $i_num; ?></td>
									<td id="pro_name" style="white-space: normal!important;"><?php echo $tmp->item_name.' '.$tmp->product_size; ?></td>
									<td align="center"><?php echo $tmp->stock; ?></td>
									<td align="center"> <?php echo $qnty = $tmp->sale_quantity; ?></td>
									<td align="right">
										<?php 
											$actual_sale_price = $tmp->actual_sale_price;
											echo sprintf("%01.2f", $actual_sale_price); 
										?>
									</td>
									<td align="right">
										<?php echo sprintf("%01.2f", $tmp->sale_quantity * $tmp->actual_sale_price); ?>
									</td>
									<td>
										<i id="delete<?php echo $i_num;?>" class="fa fa-fw fa-remove delete_product" style="color: red;cursor:pointer;" ></i>      <!-- id="delete" -->
										<i id="edit<?php echo $i_num;?>" class="fa fa-edit edit_quantty" style="color: green;cursor:pointer;" ></i>      <!-- id="edit" -->
									</td>
									
									<input type="hidden" id="pro_duct_id" value="<?php echo $tmp->product_id; ?>">
									<input type="hidden" id="pro_duct_idd<?php echo $i_num;?>" value="<?php echo $tmp->product_id; ?>">
									<input type="hidden" id="sale_stock_id" value="<?php echo $tmp->sale_quantity; ?>">
									<input type="hidden" id="specification_id<?php echo $i_num;?>" value="<?php echo $tmp->product_specification; ?>">
									<input type="hidden" id="stock_id<?php echo $i_num;?>" value="<?php echo $tmp->stock; ?>">
									<input type="hidden" id="sale_id<?php echo $i_num;?>" value="<?php echo $tmp->general_unit_sale_price; ?>">
									<input type="hidden" id="buy_id<?php echo $i_num;?>" value="<?php echo $tmp->unit_buy_price; ?>">
									<input type="hidden" id="quantti_id<?php echo $i_num;?>" value="<?php echo $tmp->sale_quantity; ?>">
									<input type="hidden" id="temp_details_modal<?php echo $i_num;?>" value="<?php echo $tmp->temp_sale_details_id; ?>">
									<td style="display: none;"><?php echo $tmp->product_id . "<>" . $qnty ."<>". $actual_sale_price; ?></td>
								</tr>

					<?php 
			                	$i_num++; 
			                    $total_qnty += $qnty;
								$price_per_product     = $qnty * $actual_sale_price;
								$sub_to += $price_per_product;
			                    $vat        = 0;
							 }
	                 		$vat     = $vat;
	                 ?>
			                <input type="hidden" value="<?php echo $total_qnty; 	?>"     id="hid_qty" >
			                <input type="hidden" value="<?php echo $sub_to;     	?>"     id="hid_sub_to" >
			                <input type="hidden" value="<?php echo $vat;         	?>"     id="hid_vat" >
	               <?php 
	           			}
	               ?>
	               		<input type="hidden" value="<?php echo $return_adjust; ?>" 	id="hid_return_adjust" >
	               		<input type="hidden" value="<?php echo $return_id; ?>" 	id="hid_return_id" >
				</table>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		    <form id="customer" action="<?php echo base_url();?>customer/create" method="post" class="form-horizontal">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <div class="row">
			        	<div class="col-md-6">
			        		<h3 class="modal-title" id="exampleModalLabel">Create a new customer</h3>
			        	</div>
			        	<div class="col-md-6">
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
			        	</div>
			        </div>
			      </div>
			      <div class="modal-body">
					<div class="box-body">
						<div class="box-body">
							<div class="row">
								<div class="col-md-6 left">
									<div class="form-group">
									   <label for="inputEmail3" class="control-label">Name <span class="text-danger">*</span></label>
										<input type="text" name="customer_name" value="" class="form-control customer_name" placeholder="Customer Name" autocomplete="off">
									</div>
									<div class="form-group">
									    <label for="inputEmail3" class="control-label">Type </label>
										<input type="text" name="customer_type" value="" class="form-control customer_type" placeholder="Type" autocomplete="off">
									</div>
									<div class="form-group">
									  	<label for="inputEmail3" class="control-label">Number <span class="text-danger">*</span></label>
										<input type="text" name="customer_contact_no" value="" class="form-control customer_contact_no" placeholder="Contact Number" autocomplete="off">
									</div>
									<div class="form-group">
									    <label for="inputEmail3" class="control-label">Mode </label>
										<input type="text" name="customer_mode" value="" class="form-control customer_mode" placeholder="Mode" autocomplete="off">
									</div>
								</div>
								<div class="col-md-6 right">
									<div class="form-group">
									    <label for="inputEmail3" class="control-label">Email </label>
										<input type="text" name="customer_email" value="" class="form-control customer_email text-lowercase" placeholder="Email Address" autocomplete="off">
									</div>
									<div class="form-group">
									    <label for="inputEmail3" class="control-label">Balance </label>
										<input type="text" name="int_balance" value="" class="form-control int_balance" placeholder="Balance" autocomplete="off">
									</div>
									<div class="form-group">
									    <label for="inputEmail3" class="control-label">Address</label>
										<textarea name="customer_address" cols="10" rows="1" class="form-control customer_address" maxlength="300" placeholder="customer Address"></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" id="close_customer_modal">Close</button>
			        <button type="submit" class="btn btn-success" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>
					<button type="reset" id="reset_btn" class="btn btn-warning"><i class="fa fa-fw fa-refresh"></i> Reset</button>
			      </div>
			    </div>
			  </div>
		  </form>
		</div>

		<div class="modal fade" id="show_quantty_modal" >
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus"></i> Edit Quantity and Price</h4>
			  </div>
			  <form id="change_quanttyy_form" action="<?php echo base_url(); ?>sale/change_sale_quantity2" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
			  <div class="modal-body">
				<div class="input-group">
				  <span class="input-group-addon">Quantity</span>
				  <input name="sale_quantity" type="text" class="form-control quantityy" placeholder="Quantity" />
				  <span class="input-group-addon">Stock</span>
				  <input name="stock_quantity" type="text" class="form-control stockk" placeholder="Stock" disabled />
				</div>
				<div class="separator10"></div>
				<div class="input-group">
				  <span class="input-group-addon">Sale</span>
				  <input name="sale_price" type="text" class="form-control salee" placeholder="Sale"/>
				  <span class="input-group-addon">Buy</span>
				  <input name="buy_price" type="text" class="form-control buyy" placeholder="Buy" disabled />
				</div>
				<input type="hidden" name="temp_details_id" class="temp_details_id">
			  </div>
			  <div class="modal-footer">
				<button type="submit" class="btn btn-primary">Change</button>
				<button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			  </form>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div>

		<div class="modal fade" id="show_product_individual_add_modal" >
			<div class="modal-dialog" style="width:600px;">
				<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> <span id="indi_pro_name"></span></h4>
					</div>
					<form id="add_product_serial_form" action="<?php echo base_url();?>product/update_new_product_serial" method="post" autocomplete="off" enctype="multipart/form-data" role="form" class="form-horizontal">
						<div class="modal-body" style="padding: 0px;">
							<div class="col-md-12">
								<div class="inner_table_2">
									<div class="box-body">	
										<span id="pro_serial_input"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Save Product</button>
							<button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>



		<!-- Modal -->
		
        <!--/.Modal-->
	</section>
</div>