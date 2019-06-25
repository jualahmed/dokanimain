<?php $this->load->view('include/header_for_new_sale'); ?>
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
		 width:100px;
	
		 height:70px;
	}
	.style2{
		 width:126px;
	
		 height:150px;
	}
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
	    height: 410px;
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
	    height: 350px;
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
<?php 

	$this->load->config('custom_config'); 
	$value_added_tax = $this->config->item('VAT');
	$allow_negative_stock = $this->config->item('allow_negative_stock');
	$tp_price_purchase = $this->config->item('tp_price_purchase');
	$tp_price_vat_purchase = $this->config->item('tp_price_vat_purchase');
	$discount_limit = $this->config->item('discount_limit');
	$product_sale_return = $this->config->item('product_sale_return');
	//$value_added_tax = 0;

?>
<input type="hidden" id="allow_negative_stock" value="<?php echo $allow_negative_stock; ?>">
<input type="hidden" id="value_added_tax" value="<?php echo $value_added_tax; ?>">
<input type="hidden" id="discount_limit" value="<?php echo $discount_limit; ?>">
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
				<div class="box box-info">
			        <div class="box-body">
						<input type="hidden" value="<?php echo $currrent_temp_sale_id = $this->session->userdata('currrent_temp_sale_id');?>" id="new_temp_sale_id">
			        	<div id='num_of_sale'>
			        		<?php
            					$ind = 0; 
            					if($sales != FALSE) { 
									$Tmp_name = '';
	              					foreach($sales->result() as $tmp ){
										if($tmp->temp_sale_type=='sale' || $tmp->temp_sale_type==''){
											$Tmp_name = 'Sale';
										}
										else if($tmp->temp_sale_type=='cart'){
											$Tmp_name = 'Cart';
										}
	                					if($current_sale == $tmp->temp_sale_id)
	                  						echo "<button id=sale_new" . $tmp->temp_sale_id . " class=\"sale_selection btn btn-success \" onclick=\"getSaleId(this.id)\"> <i class=\"fa fa-spinner fa-spin\"> </i> <i class=\"fa fa-fw fa-cart-arrow-down\"> </i> ".$Tmp_name.' '. ++$ind . "</button>&nbsp;";

	                					else echo "<button id=sale_new" . $tmp->temp_sale_id . " class=\"sale_selection btn btn-info\" onclick=\"getSaleId(this.id)\"> <i class=\"fa fa-fw fa-cart-arrow-down\"> </i>" .$Tmp_name.' '. ++$ind . "</button>&nbsp;";
	              					}

          						}
          					?>
			        	</div>
			        	<div>
			        		<button class="btn btn-info" id="btn_sale" name="sale_btn">
								<i class="fa fa-fw fa-cart-arrow-down"></i>ADD SALE (Shortcut : Alt+S)
			        		</button>
			        	</div>
			        </div>
			    </div>
		    </div>
		</div>

		<div class="col-md-6" style="padding-right: 0px;padding-left: 0px;">
			<div class="col-md-12" style="padding-right: 2px;padding-left: 5px;">
				<div class="box box-info" style="margin-bottom: 0px;">
		           	<div class="box-body">
		                 	<table width="100%">
		                 		<tr>
		                 			<!--td width="30%" style="padding: 0px 2px;">
		                 				<input type="text" class="form-control search" id="search_by_generic_name" placeholder="Name" disabled>
		                 			</td>
									<td width="20%" style="padding: 0px 2px 0px 0px;">
		                 				<input type="text" class="form-control search" id="search_by_barcode" placeholder="Barcode" autofocus="on">
		                 			</td-->
		                 			<td width="50%" style="padding: 0px 2px;">
		                 				<input type="text" class="form-control search" id="search_by_product_name" placeholder="Search Product" autofocus="on">
		                 			</td>
									<td width="40%" style="padding: 0px 2px;">
		                 				<input type="text" class="form-control search" id="search_by_warran_product_model" placeholder="Search Warranty Product">
		                 			</td>
									<!--td width="15%" style="padding: 0px 2px;">
		                 				<input type="text" class="form-control quantity" id="buy_price_check" placeholder="Buy Price">
		                 			</td-->
		                 			
									<!--td width="15%" style="padding: 0px 2px;">
		                 				<input type="text" class="form-control quantity" id="new_mrp_price" placeholder="Sale Price" -->
		                 			</td>
									<td width="10%" style="padding: 0px 2px;">
		                 				<input type="text" class="form-control quantity" id="product_quantity" placeholder="Quantity" >
		                 			</td>
		                 		</tr>
		                 	</table>
							<input type="hidden" name="temp_pro_id" id="temp_pro_id" />
		                 	<input type="hidden" name="temp_pro_data" id="temp_pro_data" />
			            	<input type="hidden" name="temp_pro_qty" id="temp_pro_qty" />
			                <input type="hidden" name="pro_name" id="pro_name" />
			            	<input type="hidden" name="price" id="price" />
			            	<input type="hidden" name="mrp_price" id="buy_price_check" />
			            	<input type="hidden" id="new_mrp_price" />
							<input type="hidden" name="mrp_price" id="mrp_price" />
			            	<input type="hidden" id="buy_price" />
							<input type="hidden" id="product_specification" >
              			<hr style="margin-top: 4px;margin-bottom: 3px;border: 0;border-top: 1px solid #eee;">
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
								<!--td>
									<input type="text" class="form-control sale_input_custom_styl align_right" id="payment" placeholder="Received">
								</td-->
								<td colspan="2">
									<!--span class="has-float-label">
										<label for="first" style="color:red;font-weight:bold;" id="received_alert" style="display:none;"></label>
									</span-->
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
			                    <!--input type="text" class="form-control sale_input_custom_styl" id="select_customer" placeholder="Customer"-->
								<?php 
									
									if($current_sale_customer->num_rows > 0)
									{
										$query = $current_sale_customer->row();
										$customer_name=$query->customer_name;
										$customer_id=$query->customer_id;
										$customer_contact_no=$query->customer_contact_no;
								?>
								<input type="hidden" id="selected_customer_id" value="<?php echo $customer_id;?>">
								<select id="select_customer" class="form-control select2 customer_name" style="width:92%;">
									<option>Select Customer</option>
									<option value="<?php echo $customer_id;?>" selected><?php echo $customer_id;?>. <?php echo $customer_name;?> (<?php echo $customer_contact_no;?>)</option>
									<?php
									foreach ($customer_info->result_array() as $tmp)
									{
									?>
										<option value="<?php echo $tmp['customer_id'];?>"><?php echo $tmp['customer_id'];?>. <?php echo $tmp['customer_name'];?> (<?php echo $tmp['customer_contact_no'];?>)</option>
									<?php
									}
									
									?>
								</select>
								<?php
									}
									else
									{
								?>
								 <input type="hidden" id="selected_customer_id">
								<select id="select_customer" class="form-control select2 customer_name" style="width:92%;">
									<option>Select Customer</option>
									<?php
									foreach ($customer_info->result_array() as $tmp)
									{
									?>
										<option value="<?php echo $tmp['customer_id'];?>"><?php echo $tmp['customer_id'];?>. <?php echo $tmp['customer_name'];?> (<?php echo $tmp['customer_contact_no'];?>)</option>
									<?php
									}
									
									?>
								</select>
								<?php
									}
								?>
								<button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#show_add_client_modal">+</button>
			                  </td>
			                </tr>
			                <!--tr>
			                  <td style="vertical-align: middle;">Customer Name: </td>
			                  <td colspan="5">
			                    <input type="text" class="form-control sale_input_custom_styl" id="customer_name" placeholder="Customer Name">
			                  </td>
			                </tr>
			                <tr>
			                  <td style="vertical-align: middle;">Customer Phone: </td>
			                  <td colspan="5">
			                    <input type="text" class="form-control sale_input_custom_styl" id="customer_phone" placeholder="Customer Phone">
			                  </td>
			                </tr-->
              			</table>
              		</div>
		        </div>
			</div>

			<div class="col-md-12 col-md-offset-" style="padding-right: 2px;padding-left: 5px;">
				<div class="box" style="margin-bottom: 0px;">
		           	<div class="box-body" style="padding: 4px;">
						<input type="hidden" id="is_sale_active" value="<?php echo $current_sale; ?>">
              			<div style="float:left;width:100%;">
              				<div style="float:left;width:20%;height: 150px;">
								<button type="button" class="btn btn-primary btn_for_sale style2" id="quick_sale">Cash Sale<br><span>(Shortcut : Alt+Q)</span></button>
							</div>
							<div style="float:left;width:60%;">
								<center>
								<button type="button" class="btn btn-primary btn_for_sale style" id="quotation">Quotation </button>
								<button type="button" class="btn btn-danger btn_for_sale style" id="cancel">Cancel <br><span>(Shortcut : Alt+X)</span></button>
								<?php
								if($product_sale_return!=0)
								{
								?>
								<button type="button" class="btn btn-primary btn_for_sale style" id="sale_return">Sale Return</button>
								<?php
								}
								?>
								<?php
									if(!empty($card_info)){
										foreach($card_info->result() as $field){
										?>
										<?php 
											if($field->card_name =='MASTER')
											{
										?>
											<button type="button" class="btn btn-info btn_for_sale style" style="margin-top: 8px;" id="master_id" value="<?php echo $field->card_id;?>"><img src="<?php echo base_url();?>assets/assets2/dist/img/credit/mastercard.png" alt="Mastercard"><br>(Shortcut : Alt+M)</button>
											<input type="hidden" id="bank_id" value="<?php echo $field->bank_id;?>">
										<?php
											}
											else if($field->card_name =='VISA')
											{
										?>
											<button type="button" class="btn btn-info btn_for_sale style" style="margin-top: 8px;" id="visa_id" value="<?php echo $field->card_id;?>"><img src="<?php echo base_url();?>assets/assets2/dist/img/credit/visa.png" alt="Visa"><br>(Shortcut : Alt+V)</button>
											<input type="hidden" id="bank_id" value="<?php echo $field->bank_id;?>">
										<?php
											}
											else if($field->card_name =='AMERICAN EXPRESS')
											{
										?>
											<button type="button" class="btn btn-info btn_for_sale style" style="margin-top: 8px;" id="american_express_id" value="<?php echo $field->card_id;?>"><img src="<?php echo base_url();?>assets/assets2/dist/img/credit/american-express.png" alt="American Express"><br>(Shortcut : Alt+A)</button>
											<input type="hidden" id="bank_id" value="<?php echo $field->bank_id;?>">
										<?php
											}
										}
									}
								?>
								</center>
							</div>
							<div style="float:right;width:20%;height: 150px;">
								<button type="button" class="btn btn-primary btn_for_sale style2" id="credit_sale">Credit Sale <br><span>(Shortcut : Alt+C)</span></button>
							</div>
              			</div>
              		</div>
		        </div>
			</div>

		</div>
		
		<!-- listing all product -->
		<div class="row">
			<div class="col-md-6" style="padding-right: 0px;padding-left: 0px;">
				<div class="col-md-12" style="padding-right: 10px;padding-left: 10px;">
					<div class="box box-info"> 
						<div class="box-body">
			        	<div class="wrap">
							<table class="head" id="selected_product_list_tbl">
			              		<tr class="bg-aqua color-palette">
			              			<td style="width: 7%;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;font-weight: 500;">
			              				SL No
			              			</td>
									<td style="width: 40%;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;font-weight: 500;">
			              				Name
			              			</td>
			              			<td style="text-align: center;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;font-weight: 500;">
			              				Stock
			              			</td>
			              			<td style="text-align: center;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;font-weight: 500;">
			              				QTY
			              			</td>
									<!--td style="text-align: center;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;font-weight: 500;">
			              				MRP
			              			</td-->
									<td style="text-align: center;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;font-weight: 500;">
			              				Sale
			              			</td>
			              			<td style="text-align: center;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;font-weight: 500;">
			              				Total
			              			</td>
			              			<td style="text-align: center;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;font-weight: 500;">
			              				 <i class="fa fa-fw fa-wrench"></i>
			              			</td>
			              		</tr>
							</table>
							
			              	<!--/thead-->
			              	<div class="inner_table">
								<table class="new_data_2" id="search_data">
			              		<?php $qnty = 0;$total_sale = 0;$total_buy_price = 0;$total_profit = 0;$total_sale_price = 0;$final_profit_percent = 0; $buy_price = 0;$sale_price = 0;$profit = 0;$profit_percent = 0; $total_qnty = 0; $sub_to = 0; $vat = 0; $ind = 1; ?>
	                			<?php 
	                				if($tmp_item != FALSE)
	                				{ 
	                					$i_num = 1;
										foreach($tmp_item->result() as $tmp)
	                					{
	                			?>
											<tr style="background-color: white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;    font-weight: 500;">
												<td style="text-align: left; width: 7%;" id="pro_name"><?php echo $i_num; ?></td>
												<td style="text-align: left; width: 40%;" id="pro_name"><?php echo $tmp->item_name.' '.$tmp->product_size; ?></td>
												<td style="text-align: center;"><?php echo $tmp->stock; ?></td>
												<td style="text-align: center;"> <?php echo $qnty = $tmp->sale_quantity; ?></td>
												<!--td style="text-align: right;"><?php echo $mrp_price = $tmp->unit_sale_price; ?></td-->
												<td style="text-align: right;"><?php echo $sale_price = $tmp->general_unit_sale_price; ?></td>
												<td style="text-align: right;"><?php echo $tmp->sale_quantity * $tmp->general_unit_sale_price; ?></td>
												<td style="text-align: center; ">
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
												<input type="hidden" id="temp_details_modal<?php echo $i_num;?>" value="<?php echo $tmp -> temp_sale_details_id; ?>">
												<td style="display: none;"><?php echo $tmp->product_id . "<>" . $qnty ."<>". $sale_price; ?></td>
											</tr>

				                <?php 
						                	$i_num++; 
						                    $total_qnty += $qnty;
						                    $sub_to     = ($sub_to + ($qnty * $sale_price));
						                    //$vat        = ($vat + ((($qnty * $price) * $value_added_tax) / 100));
						                    $vat        = 0;
				                 		}
				                 		$sub_to  = round($sub_to);
				                 		$vat     = round($vat);
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
			            </div>
			        </div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="show_add_client_modal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add New Client</h4>
					</div>
					<form id="add_client_form" action="<?php echo base_url(); ?>registration_controller/create_new_client" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
						<div class="modal-body">
							<div class="input-group input-group-sm">
								<span class="input-group-addon">Client Name</span>
								<input name="customer_name" type="text" class="form-control client_name" placeholder="Client Name" required="required" />
							</div>
							<div class="separator10"></div>
							<div class="input-group input-group-sm">
								<span class="input-group-addon">Contact</span>
								<input name="customer_contact_no" type="text" class="form-control" placeholder="Contact Number"  />
							</div>
							<div class="separator10"></div>
							<div class="input-group input-group-sm">
								<span class="input-group-addon">Email</span>
								<input name="customer_email" type="text" value="demo@gmail.com" class="form-control"  />
							</div>
							<div class="separator10"></div>
							<div class="input-group input-group-sm">
								<span class="input-group-addon">Address</span>
								<textarea name="customer_address" class="form-control input-xlarge" id="textarea" rows="2" value="N/A" >N/A</textarea>  
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Save Customer</button>
							<button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>

		<div class="modal fade" id="show_quantty_modal" >
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus"></i> Edit Quantity and Price</h4>
			  </div>
			  <form id="change_quanttyy_form" action="<?php echo base_url(); ?>sale_controller/change_sale_quantity2" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
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
					<form id="add_product_serial_form" action="<?php echo base_url();?>setup/update_new_product_serial" method="post" autocomplete="off" enctype="multipart/form-data" role="form" class="form-horizontal">
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
		<div id="sale_return_modal" class="modal">
          <div class="modal-dialog" style="width: 700px; margin-top: 10px;">
          	<form id="sale_return_from">
	            <div class="modal-content">
	              <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                  <span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">
	                	<span class="glyphicon glyphicon-wrench " style="color: #db8b0b;"></span>
	                	Sale Return
	                </h4>
	              </div>
	              <div class="modal-body">
					<script type="text/javascript">
						$(document).ready(function() {
							$('#received').on('keyup', function(service)
							{
								var length=$(this).val().length;
								if(length>=1)
								{
									$("#credit_sale").prop("disabled", true);
								}
								else
								{
									$("#credit_sale").prop("disabled", false);
								}
							});
							$('#add_client_form').on('submit', function(service){
								service.preventDefault();
								var submiturl = $(this).attr('action');
								var methods = $(this).attr('method');
								 $.ajax({
									url: submiturl,
									type: methods,
									data: $(this).serialize(),
									success:function(result){
										$('#show_add_client_modal').modal('hide');
										if(result !='')
										{
											alert('Data Successfully Saved.');
											select_new_entry_with_id('customer_info','customer_id','customer_name','customer_name','');
											//service_provider_info', 'service_provider_name
											$(".select2").select2();
											$("#selected_customer_id").val(result);
										}
										else if(result == 'exist'){
											alert('Data Already Exists.');
											select_new_entry_with_id('customer_info','customer_id','customer_name','customer_name','client_name');
											$(".select2").select2();
										}
										else if(result == 'error'){
											alert('Data Not Successfully Saved.');
										}
									 },
									error: function (jXHR, textStatus, errorThrown) {html("")}
								});
								
							});
						});
						function select_new_entry_with_id(table,id,class_name,field,valuess)
						{
							if(valuess!=''){
								var vlau = $('.'+valuess).val();
							}
							else{
								var vlau = '';
							}
							var submiturl = $('#ret_and_sel_with_id').val();
							var methods = 'GET';
							$.ajax({
								url: submiturl+'/'+table+'/'+id+'/'+field+'/'+vlau,
								type: 'GET',
								success:function(result){
									var arr = result.split('","');
									var valu = arr[1].split('"]');
									$('.'+class_name).html(arr[0]);
									$('.'+class_name).val(valu[0]);
								},
								error: function (jXHR, textStatus, errorThrown) {html("")}
							});
						}
						$(function()
						{
							$('#sale_re_qnty').on('keydown', function(e)
							{

								if(e.keyCode == 13)
								{
									var pro_id 			= $('#sal_re_pro_id').val();
									var pro_name 		= $('#sal_re_pro_name').val();
									var unit_price 		= parseFloat($('#sal_re_pro_pric').val());
									var buy_pric 		= parseFloat($('#sal_re_buy_pro_pric').val());
									var qnty 			= parseFloat($('#sale_re_qnty').val());
									var sale_quantity 	= parseFloat($('#sale_quantity').val());
									var invoice 		= $('#searchByInvoice').val();
									if(qnty > sale_quantity)
									{
										 alert('Sale Quantity was '+sale_quantity);
									}
									else 
									{
										 
										if(qnty != '' && !isNaN(qnty) && qnty > 0 && pro_name != '' && pro_id != '' && unit_price != ''&& buy_pric != '' && invoice != '')
										{
											 $.ajax({
												url 	: '<?php echo base_url();?>sale_controller/addToSaleReturn',
												type 	: 'POST',
												cache: false,
												data 	: {pro_id: pro_id, pro_name: pro_name, unit_price: unit_price,buy_pric: buy_pric, qnty: qnty, invoice: invoice},
												success : function(data)
												{
													$('#sale_return_list').last().append(data);
													
													var total_final = 0.00;
													$('.total_sale_price_final').each(function(){
														total_final += parseFloat($(this).text()); 
													});
													$('#total_sale_retrun_price').html(total_final);
													
													var balance_amount = $('#ledger_amount_balance').html();
													if(total_final > balance_amount)
													{
														//alert('1');
														var return_adjustment_amount = total_final - balance_amount;
													}
													else if(balance_amount >= total_final)
													{
														//alert('2');
														var return_adjustment_amount = total_final;
													}
													else if(total_final < balance_amount)
													{
														//alert('3');
														var return_adjustment_amount = total_final;
													}
													
													$('#return_adjustment_amount').val(return_adjustment_amount);

													$('#sale_re_qnty').val('');
													$('#productt_id').val('');
													$('#productt_id').select2();
													//$('#searchByInvoice').val('');
													$('#sal_re_pro_id').val('');
													$('#sal_re_pro_name').val('');
													$('#sal_re_pro_pric').val('');
													$('#sal_re_buy_pro_pric').val('');
													$('#searchByInvoice').focus();
												}
											});
										}
									}
								}
							});

							/*start*/
						    $('#sale_return_submit').on('click', function(){

						    	if(confirm('Are you sure?'))
								{
						      		$('#sale_return_modal').modal('hide');
									var return_adjustment_amount = $('#return_adjustment_amount').val();
									var customer_id_ledger = $('#customer_id_ledger').html();
									var invoice_ledger_id = $('#searchByInvoice').val();
						      		if($('#sale_return_tbl  > tbody > tr').length)
									{
								      $.ajax({
								          url     : '<?php echo base_url();?>sale_controller/doSaleReturn',
								          type    : "POST",
								          dataType    : "JSON",
										  cache: false,
											async: false,
								          data    : {'return_adjustment_amount':return_adjustment_amount,'customer_id_ledger':customer_id_ledger,'invoice_ledger_id':invoice_ledger_id},
								          success : function(result)
										  {
											var total2 = result.amount['total_amount'];
											var return_id = result.amount['sale_return_id'];
											$('#hid_return_id').val(return_id);
								          	var return_adjust 	= $('#return_adjust').val();
								          	var total 			= $('#total').val();
								          	var payable 		= 0;

								          	if(return_adjust != '')
											{
								          		return_adjust 	= parseFloat(return_adjust);
								          		total2 			= parseFloat(total2);
								          		var tmp 		= Math.round(total2+return_adjust)
								          		$('#return_adjust').val(tmp);

								          		if(total != '' && !isNaN(total))
												{
								          			total 		= parseFloat(total);
								          			payable 	= total - (total2+return_adjust);
								          			if(payable > 0)
													{
								          				payable 	= Math.round(payable);
								          				$('#payable').val(payable);
								          				
								          			}
								          		}
								          	}
								          	else
											{
								          		$('#return_adjust').val(Math.round(parseFloat(total2)));
								          		
								          		if(total != '' && !isNaN(total)){
								          			total 		= parseFloat(total);
								          			total2 		= parseFloat(total2);
								          			payable 	= total - (total2);

								          			if(payable > 0){
								          				payable 	= Math.round(payable);
								          				$('#payable').val(payable);
								          			}
								          		}	
								          	}
											location.reload();
								          	$('#sal_re_pro_id').val('');
											$('#sal_re_pro_name').val('');
											$('#sal_re_pro_pric').val('');
											$('#sal_re_buy_pro_pric').val('');
								          	$('#searchByInvoice').focus();
								          	$('#sale_return_list').empty();
								          }
								      });
							  		}
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
										$('#sal_re_buy_pro_pric').val('');
						      			$('#searchByInvoice').focus();
						      		}
						      	});
						      }

						  });

						  $('#sale_return_list').on('click', "[name='dlt_btn']" ,function()
						  {
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
						  				url  		: '<?php echo base_url();?>sale_controller/deleteProductFromSaleReturn',
						  				type 		: 'POST',
						  				data 		: {pro_id: pro_id},
						  				success 	: function(result){
											selected_tr.closest('tr').remove();
						  					swal('Deleted!',
								  				':)',
								  				'success'
							  				)
											var total_final = 0.00;
											$('.total_sale_price_final').each(function(){
												total_final += parseFloat($(this).text()); 
											});
											$('#total_sale_retrun_price').html(total_final);
											$('#return_adjustment_amount').val(total_final);
						  				}
						  			});
						  		});
						    });
						});
						
						$(document).ready(function()
						{
							$('#searchByInvoice').keyup(function(evv){
								var outputs='';
								var amount ='';
								var all_sale ='';
								var all_collection ='';
								var all_sale_return ='';
								var all_balance ='';
								var mm =0;
								if(evv.keyCode == 13)
								{
									var invoice=parseInt($(this).val());
									$.ajax
									({
										url: '<?php echo base_url();?>sale_controller/get_invoice_product_list',
										type: 'POST',
										dataType: 'json',
										cache: false,
										data: {'invoice':invoice},
										success:function(result)
										{	
											
											outputs+='<option value="#">Select Product</option>';
											for(var i=0; i<result['product_report'].length; i++)
											{
												all_sale = '';
												for(var kkk=0; kkk<result['product_report'][i]['sale_amount_name'].length; kkk++)
												{
													if(mm == 0)
													{
														all_sale+= result['product_report'][i]['sale_amount_name'][kkk]['amount'];
													}
													else
													{
														all_sale+= result['product_report'][i]['sale_amount_name'][kkk]['amount'];
													}
																
													mm++;
												}
												all_collection = '';
												for(var kkkk=0; kkkk<result['product_report'][i]['collection_amount_name'].length; kkkk++)
												{
													if(mm== 0)
													{
														all_collection+= result['product_report'][i]['collection_amount_name'][kkkk]['amount'];
													}
													else
													{
														all_collection+= result['product_report'][i]['collection_amount_name'][kkkk]['amount'];
													}
																
													mm++;
												}
												all_sale_return = '';
												for(var kkkkk=0; kkkkk<result['product_report'][i]['return_amount_name'].length; kkkkk++)
												{
													if(mm== 0)
													{
														all_sale_return+= result['product_report'][i]['return_amount_name'][kkkkk]['amount'];
													}
													else
													{
														all_sale_return+= result['product_report'][i]['return_amount_name'][kkkkk]['amount'];
													}
																
													mm++;
												}
										
												outputs+='<option value="'+result['product_report'][i].product_id+'">'+result['product_report'][i].product_name+'</option>';
											}
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

											/* var tot_fi = all_collection + all_sale_return;
											var tot_fi2 = all_sale - tot_fi;
											alert(all_sale);
											alert(tot_fi);
											alert(tot_fi2);
											if(tot_fi2!=0)
											{
											 */	if(isNaN(balance_amount))
												{
													balance_amount =0;
												}
												if(isNaN(sale_retrun_amount))
												{
													sale_retrun_amount =0;
												}

												$('#all_sa_col').show();
												$("#customer_id_ledger").html(customer_id); 
												$("#customer_name_ledger").html(customer_name); 
												$("#ledger_amount_sale").html(parseFloat(sale_amount).toFixed(2));
												$("#ledger_amount_collection").html(parseFloat(balance_amount).toFixed(2));
												$("#ledger_amount_sale_return").html(parseFloat(sale_retrun_amount).toFixed(2));
												var totbalac = parseFloat(balance_amount) + parseFloat(sale_retrun_amount);

												$("#ledger_amount_balance").html(parseFloat(sale_amount - totbalac).toFixed(2));
												
												var tot_return_price = $('#total_sale_retrun_price').html();
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
											/* }
											else
											{
												$('#all_sa_col').hide();
												$('#return_adjustment_amount').val(0);
											} */
											$("#productt_id").html(outputs); 

											
											
											
											
										},
										error: function (jXHR, textStatus, errorThrown) {}
									});
									
								}
								else{
									
								}
							});
							
							$("#productt_id").on("change",function()
							{
								var urlx='<?php echo base_url();?>sale_controller/get_product_list';
								var productt_id=$(this).val();
								var invoice_id=$('#searchByInvoice').val();
								var outputs='';
								$.ajax
								({
									url: urlx,
									type: 'POST',
									dataType: 'json',
									data: {'product_id':productt_id,'invoice_id':invoice_id},
									success:function(result)
									{
										
										var exact_sale_price =parseFloat(result.exact_sale_price);
										var unit_buy_price =parseFloat(result.unit_buy_price);
										$('#sal_re_pro_id').val(result.product_id);
										$('#sale_quantity').val(result.sale_quantity);
										$('#sal_re_pro_name').val(result.product_name);
										$('#sal_re_pro_pric').val(exact_sale_price);
										$('#sal_re_buy_pro_pric').val(unit_buy_price);
										
										$("#sale_re_qnty").focus();  
									},
								});	
							});
						});
					</script>
	              	<div class="input-form">
		                <input type="text" class="form-control pull-left" id="searchByInvoice" style="width: 30%; border-radius: 0px;" placeholder="Put Invoice ID" autocomplete="off">
		                
						<select class="form-control select22 pull-left" id="productt_id" style="width: 60%;"tabindex="-1" aria-hidden="true" required="required">
							<option value="#">Select</option>
						</select>
						<input type="hidden" class="form-control pull-left" id="sale_quantity">
		                <input type="text" class="form-control pull-right" data-toggle="tooltip" style="width: 10%; border-radius: 0px; text-align: center;" id="sale_re_qnty" placeholder="Qnty">
	                </div>
	                <div id="all_sa_col" style="display:none;">
						<table class="table table-bordered remove_thead_space remove_tbody_space" id="sale_return_tbl">
							<thead>
								<tr class="bg-aqua color-palette">
									<td style="width: 16%;color: black;background: lightgray;">ID</td>
									<td style="width: 40%;color:black;color: black;background: lightgray;">Customer Name</td>
									<td style="width: 16%;text-align: right;color:black;color: black;background: lightgray;">Sale</td>
									<td style="width: 14%;text-align: right;color:black;color: black;background: lightgray;">Collection</td>
									<td style="width: 16%;text-align: right;color:black;color: black;background: lightgray;">Sale Return</td>
									<td style="width: 16%;text-align: right;color:black;background: lightgray;">Due</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><span id="customer_id_ledger"></span></td>
									<td><span id="customer_name_ledger"></span></td>
									<td style="text-align: right;"><span id="ledger_amount_sale"></span></td>
									<td style="text-align: right;"><span id="ledger_amount_collection"></span></td>
									<td style="text-align: right;"><span id="ledger_amount_sale_return"></span></td>
									<td style="text-align: right;"><span id="ledger_amount_balance"></span></td>
								</tr>
							</thead>
						</table>
					</div>
	                <br>
	                <table class="table table-bordered remove_thead_space remove_tbody_space" id="sale_return_tbl">
	                	<thead>
		                	<tr class="bg-aqua color-palette">
		                		<td style="width: 50%;color:black;">Name</td>
		                		<td style="text-align: center;color:black;">Quty</td>
		                		<td style="text-align: center;color:black;">Price</td>
		                		<td style="text-align: center;color:black;">Total</td>
		                		<td style="text-align: center;color:black;"> <i class="fa fa-fw fa-wrench"></i> </td>
		                	</tr>
	                	</thead>
	                	<tbody id="sale_return_list">
	                		<?php if($sale_return_info != FALSE){ $total_pr=0; foreach($sale_return_info->result() as $tmp){ ?>
	                		<tr>
	                			<td><?php echo $tmp->product_name; ?></td>
	                			<td style="text-align: center;"><?php echo $tmp->return_quantity;?></td>
	                			<td style="text-align: right;"><?php echo $tmp->unit_price;?></td>
	                			<td class="total_sale_price_final" style="text-align: right;"><?php echo $tmp->total_price;?></td>
	                			<td id="<?php echo $tmp->product_id; ?>" name="dlt_btn" style="text-align: center; color: red;"> 
	                				<i class="fa fa-fw fa-remove remove_btn"></i> 
	                			</td>
	                		</tr>
							
	                		<?php 
							$total_pr+=$tmp->total_price;
							}
							?>
							
							<?php 
							}
							?>

	                	</tbody>
						<tr>
							<td></td>
							<td style="text-align: center;"></td>
							<td style="text-align: right;">Total</td>
							<td style="text-align: right;" id="total_sale_retrun_price"><?php echo $total_pr;?></td>
							<td></td>
						</tr>
	                </table>
					<table class="table table-bordered remove_thead_space remove_tbody_space">
	                	<thead>
		                	<tr class="bg-aqua color-palette">
		                		<td style="width: 50%;color:black;">Total Return Adjustment</td>
		                		<td style="text-align: center;color:black;"><input type="text" class="form-control" id="return_adjustment_amount" style="width: 100%; border-radius: 0px;" placeholder="Total Return Adjustment" autocomplete="off" readonly></td>
		                	</tr>
	                	</thead>
	                </table>
	              </div>
				  
	              <input type="hidden" id="sal_re_pro_id">
	              <input type="hidden" id="sal_re_pro_name">
	              <input type="hidden" id="sal_re_pro_pric">
				  <input type="hidden" id="sal_re_buy_pro_pric">
	              <input type="hidden" id="">
	              
	              <div class="modal-footer">
	                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
	                <button type="button" class="btn btn-danger" id="cancel_sale_return">Cancel</button>
	                <input  type="submit" class="btn btn-info" id="sale_return_submit" value="OK">
	              </div>
	            </div>
	            <!-- /.modal-content -->
            </form>
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!--/.Modal-->

	</section>
</div>

<?php $this->load->view('include/footer_for_new_sale'); ?>