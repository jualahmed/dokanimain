<?php 
	$this->load->config('custom_config'); 
	$value_added_tax = $this->config->item('VAT');
	$allow_negative_stock = $this->config->item('allow_negative_stock');
	$tp_price_purchase = $this->config->item('tp_price_purchase');
	$tp_price_vat_purchase = $this->config->item('tp_price_vat_purchase');
?>
<div class="content-wrapper">
	<style>
		/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
		}

		/* Firefox */
		input[type=number] {
		-moz-appearance: textfield;
		}
		#purchase_products tr {
			font-size: 13px !important;
		}
		.serial-no-list {
			list-style: none;
			padding: 0;
			margin: 0;
		}
		.serial-no-list li {
			width: 130px;
			float: left;
			margin: 5px;
		}
	</style>
    <section class="content" id="vuejscom"> 
	    <div class="row">
	      	<div class="col-md-6">
		        <div class="box">
		            <div class="box-header with-border text-center">
						<h32 class="box-title font-weight-bold">Purchase Listing</h2>
					</div>
		            <div class="box-body">
						<table class="table table-bordered reduce_space" >
			            	<tbody>
			            		<tr style="">
			            			<td width="25%"><b>Select Receipt</b></td>
			            			<td colspan="3">
			            				  <multiselect 
			            				  v-model="selected1" 
			            				  id="ajax" 
			            				  label="distributor_name" 
			            				  track-by="receipt_id"
			            				  placeholder="Type to search Receipt" 
			            				  open-direction="bottom" 
			            				  :options="purchase_receipt_info" 
			            				  :searchable="true" 
			            				  :loading="isLoading" 
			            				  :internal-search="true" 
			            				  :clear-on-select="false" 
			            				  :close-on-select="true" 
										  :options-limit="300" 
										  :limit="3" 
										  :limit-text="limitText" 
										  :max-height="600" 
										  :show-no-results="false" 
										  :hide-selected="false">
										    <template slot="tag" slot-scope="{ option, remove }"><span class="custom__tag"><span>{{ option.product_name }} {{ option.receipt_id }}</span><span class="custom__remove" @click="remove(option)">❌</span></span></template>
										     <template slot="option" slot-scope="props">
										      <div class="option__desc">
										      	<span class="option__title" style="display: flex;">
										      		{{ props.option.distributor_name }} ({{ props.option.receipt_id }})<br> 

										      	</div></span>
										    </template>
										    <template slot="clear" slot-scope="props">
										      <div class="multiselect__clear" v-if="selectedCountries && selectedCountries.length" @mousedown.prevent.stop="clearAll(props.search)"></div>
										    </template><span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
										  </multiselect>
			            			</td>
			            		</tr>
			            	</tbody>
			            </table>
						<table class="table table-bordered purchace">
			            	<tbody id="general_info" v-if="selected1">
								<tr>
			            			<td><b>Distributor Name</b></td>
			            			<td colspan="3">
			            				{{ selected1.distributor_name }}
			            			</td>
			            		</tr>
			            		<tr>
			            			<td><b>Receipt ID</b></td>
			            			<td align="center" id="receiptid">
			            				{{ selected1.receipt_id }}
			            			</td>
			            			<td>
			            				<b>Purchase Date</b>
			            			</td>
			            			<td align="center">
			            				{{ selected1.receipt_date | custom_date }}
			            			</td>
			            		</tr>
			            		<tr>
			            			<td><b>Purchase Price</b></td>
			            			<td style="text-align:right">
			            				{{ parseFloat(selected1.purchase_amount).toFixed(2) }}
			            			</td>
			            			<td><b>Discount</b></td>
			            			<td style="text-align:right">
			            				{{ parseFloat(selected1.gift_on_purchase).toFixed(2) }}
			            			</td>
			            		</tr>
			            		<tr>
			            			<td><b>Grand Total</b></td>
			            			<td style="text-align:right">
			            				{{ parseFloat(selected1.final_amount).toFixed(2) }}
			            			</td>
			            			<td><b>Transport Cost</b></td>
			            			<td style="text-align:right">
			            				{{ parseFloat(selected1.transport_cost).toFixed(2) }}
			            			</td>
			            		</tr>
			            	</tbody>
			            	<tbody id="general_info" v-else>
								<tr>
			            			<td><b>Distributor Name</b></td>
			            			<td colspan="3">
			            				
			            			</td>
			            		</tr>
			            		<tr>
			            			<td><b>Receipt ID</b></td>
			            			<td id="receiptid">
			            				
			            			</td>
			            			<td>
			            				<b>Purchase Date</b>
			            			</td>
			            			<td>
			            				
			            			</td>
			            		</tr>
			            		<tr>
			            			<td><b>Purchase Price</b></td>
			            			<td style="text-align: right">
			            				
			            			</td>
			            			<td><b>Discount</b></td>
			            			<td style="text-align: right">
			            				
			            			</td>
			            		</tr>
			            		<tr>
			            			<td><b>Grand Total</b></td>
			            			<td style="text-align: right">
			            				
			            			</td>
			            			<td><b>Transport Cost</b></td>
			            			<td style="text-align: right">
			            			</td>
			            		</tr>
			            	</tbody>
			            </table>
						<br>
						
						<div class="row">
							<div class="col-sm-12">
								<div class="input-group input-group-md">
									<multiselect 
										v-model="selectedCountries" 
										id="ajax" 
										label="product_name" 
										track-by="product_name" 
										placeholder="type product name" 
										open-direction="bottom" 
										:options="countries" 
										:searchable="true" 
										:loading="isLoading" 
										:internal-search="false" 
										:clear-on-select="false" 
										:close-on-select="true" 
										:options-limit="300" 
										:limit="3" 
										:disabled="selected1 == ''"
										:limit-text="limitText" 
										:max-height="600" 
										:show-no-results="false" 
										:hide-selected="false" 
										@search-change="asyncFind" 
										@select="selectProduct">
										<template slot="tag" slot-scope="{ option, remove }"><span class="custom__tag"><span>{{ option.product_name }}</span><span class="custom__remove" @click="remove(option)">❌</span></span></template>
										<template slot="clear" slot-scope="props">
										<div class="multiselect__clear" v-if="selectedCountries && selectedCountries.length" @mousedown.prevent.stop="clearAll(props.search)"></div>
										</template><span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
									</multiselect>	
									<span class="input-group-btn">
										<button type="button" data-toggle="modal" data-target="#productModel" class="btn btn-block btn-primary add_product"> <i class="fa fa-plus"></i></button>
									</span>
								</div>
							</div>
						</div>
	
						<input type="hidden" id="" >
		              	<br>
		              	<form id="product_listing_form">
			              	<table class="table table-bordered reduce_space">
			              		<tbody>
			              			<tr>
			              				<td style="vertical-align: middle;font-weight: bold;">
										  Quantity:
			              				</td>
			              				<td>
			              					<input type="number" min="1" class="form-control custom_form_control quantity" :class="[errors.quantity ? 'has-error' : '']" v-model="quantity" id="quantity" name="" placeholder="Ex: 10" autocomplete="off" required>
			              				</td>
			              				<td style="width: 25%; vertical-align: middle;font-weight: bold;">Expire Date:</td>
			              				<td>
			              					<input type="text" id="datepicker" class="form-control custom_form_control" v-model="expiredate" name="" placeholder="Ex: 14-12-2016" autocomplete="off">
			              				</td>
			              			</tr>
									<?php 
										if($tp_price_purchase!=0 && $tp_price_vat_purchase!=0)
										{
									?>
									<tr>
			              				<td style="width: 25%; vertical-align: middle;font-weight: bold;" >
			              				 <b>TP:</b>
			              				</td>
			              				<td>
			              					<input type="" class="form-control custom_form_control tp_total" v-model="tp_total" style="text-align: right;" id="tp_total" name="" placeholder="Ex: 10" autocomplete="off">
			              				</td>
			              				<td style="width: 25%; vertical-align: middle;font-weight: bold;">VAT:</td>
			              				<td>
			              					<input type="" class="form-control custom_form_control vat_total" v-model="vat_total" style="text-align: right;" id="vat_total" name="" placeholder="Ex: 10" autocomplete="off">
			              				</td>
			              			</tr>
										<?php } ?>
			              			<tr>
			              				<td style="vertical-align: middle;font-weight: bold;">
			              					Total Buy Price:
			              				</td>
			              				<td>
			              					<input type="number" step="3" class="form-control custom_form_control total_buy_price" :class="[errors.total_buy_price ? 'has-error' : '']" v-model="total_buy_price" style="text-align: right;">
			              				</td >
			              				<td style="vertical-align: middle;font-weight: bold;">MRP:</td>
			              				<td style="text-align: right;">
			              					<input type="number" step="3" class="form-control custom_form_control" :class="[errors.general_sale_price ? 'has-error' : '']" v-model="general_sale_price" style="text-align: right;" placeholder="Ex: 15" autocomplete="off" required>
			              				</td>
			              			</tr>

			              			<tr>
			              				<td style="vertical-align: middle;font-weight: bold;">
			              					Unit Buy Price:
			              				</td>
			              				<td>
			              					<input type="number" step="3" class="form-control custom_form_control" :class="[errors.unit_buy_price_purchase ? 'has-error' : '']" v-model="unit_buy_price_purchase" style="text-align: right;" placeholder="Ex: 10" autocomplete="off">
			              				</td>
			              				<td style="width: 20%; vertical-align: middle;font-weight: bold;">Sale Price:</td>
			              				<td>
			              					<input type="number" step="3" class="form-control custom_form_control" :class="[errors.exclusive_sale_price ? 'has-error' : '']" v-model="exclusive_sale_price" style="text-align: right;" autocomplete="off" placeholder="Ex: 12">
			              				</td>
			              			</tr>
			              		</tbody>
			              	</table>
							<div class="box-footer" style="background: #0f77ab;">
								<center>
									<div class="col-sm-22">
										<button v-if="isReadyToCreate" type="button" @click="submit" class="btn btn-success btn-sm" name="search_random" id="submit"><i class="fa fa-fw fa-save"></i> Create</button>
										<button v-else type="button" @click="submit" class="btn btn-success btn-sm" name="search_random" id="submit" disabled><i class="fa fa-fw fa-save"></i> Create</button>
										<button type="reset" id="reset" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
										<button type="button" id="delete_purchase_invoice" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Delete</button>
									</div>
								</center>
							</div>
		              	</form>
		              	<ul class="list-group" v-if="selectedCountries && selectedCountries.has_serial_no == 1 && selectedCountries.product_warranty > 0">
		              		<li class="list-group-item" v-for="i in quantity"><b>Serial no:</b> <input v-model="allworrantyproduct[i-1]" style="display: inline;width:80%;" type="text" class="form-control" placeholder="Serial no"></li>
		              	</ul>
		            </div>
		        </div>
	      	</div>
			
	      	<div class="col-md-6" style="padding: 0px;">
		        <div class="box">
		            <div class="box-body">
			            <div class="wrap">
			            	<input type="hidden" name="" id="pur_rec_id" :value="selected1.receipt_id">
							<table class="head" id="purchase_products">
								<tr style="background-color: #2aabd2; color: white;">
									<td style="width: 4%;">No</td>
									<td style="text-align: left; width: 35%;">Product Name</td>
									<td style="text-align: center; width: 6%;">Quantity</td>
									<td style="text-align: right;width: 10%;">Unit Price</td>
									<td style="text-align: right; width: 10%;">Total Price</td>
									<td style="text-align: center; width: 7%;" ><i class="fa fa-edit"></i></td>
								</tr>
								<tr v-for="(p,index) in purchase_info[0]" :key="index">
									<td style="width: 4%;">{{ index+1 }}</td>
									<td style="width: 35%;">{{ p.product_name }}</td>
									<td style="text-align: center; width: 6%;">{{ p.purchase_quantity }}</td>
									<td style="text-align: right;width: 10%;">{{ parseFloat(p.unit_buy_price).toFixed(2) }}</td>
									<td style="text-align: right;width: 10%;">{{ parseFloat(p.purchase_quantity*p.unit_buy_price).toFixed(2) }}</td>
									<td style="text-align: center;width: 6%;">
									  <i
									  	data-toggle="modal" data-target="#edit_modal" 
									    class="fa fa-fw fa-edit css_for_cursor"
									    style="color: #db8b0b; "
									    name="edit"
									    title="Edit"
									    :id="p.product_id"
									    :purchase_id="p.purchase_id"
									  ></i>
									  <i
									    class="fa fa-fw fa-remove css_for_cursor"
									    style="color: red; "
									    @click="removePurchaseItem(p.purchase_id)"
									    name="remove"
									    title="Remove"
									  ></i>
									</td>
								</tr>
								<tr style="background-color: #2aabd2; color: white;">
									<td style="width: 4%;"></td>
									<td style="width: 35%;text-align: right;">Total</td>
									<td style="width: 6%;text-align: center;">{{ totalqty }}</td>
									<td style="text-align: center; width: 10%;"></td>
									<td style="text-align: right;width: 10%;">{{ parseFloat(tunit_buy_price).toFixed(2) }}</td>
									<td style="text-align: center; width: 7%;" ></td>
								</tr>	
							</table>
						</div>
		            </div>
		        </div>
	      	</div>

			<div class="modal" id="edit_modal">
				<div class="modal-dialog" style="width: 60%;">
				<form id="edit_modal_form" class="form-horizontal">
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">
							<span class="glyphicon glyphicon-edit" style="color: #db8b0b;"></span>
							Edit
						</h4>
						</div>
						<div class="modal-body">
						<input type="hidden" class="form-control" name="purchase_id" id="purchase_id" style="text-align: right;" placeholder="Ex: 100" required="on" autocomplete="off">
						<table class="table table-bordered serial_qnt_price" >
							<tr>
								<td style="vertical-align: middle;">Quantity: </td>
								<td>
									<input type="hidden" id="qty_hidden">
									<input type="text" class="form-control" id="qty" name="qty" style="text-align: right;" placeholder="Ex: 100" required="on" autocomplete="off">
								</td>
							</tr>
							<tr>
								<td style="vertical-align: middle;">Unit Buy Price: </td>
								<td>
									<input type="text" class="form-control" id="u_b_p" name="u_b_p" style="text-align: right;" placeholder="Ex: 10" required="on" autocomplete="off">
								</td>
							</tr>
							<tr>
								<td style="vertical-align: middle;"> General Sale Price: </td>
								<td>
									<input type="text" class="form-control" id="g_b_p" name="u_b_p" style="text-align: right;" placeholder="Ex: 10" required="on" autocomplete="off">
								</td>
							</tr>
							<tr>
								<td style="vertical-align: middle;">Exclusive Sale Price: </td>
								<td>
									<input type="text" class="form-control" id="e_b_p" name="u_b_p" style="text-align: right;" placeholder="Ex: 10" required="on" autocomplete="off">
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<ul class="serial-no-list">
										
									</ul>
								</td>
							</tr>
						</table>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-info" id="save_change" value="Save">
						</div>
					</div>
					<!-- modal-content -->
				</form>
				</div>
				<!-- modal-dialog -->
			</div>

			<!-- Modal -->
			<div class="modal fade" id="productModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<form id="product_form" autocomplete="off" action="<?php echo base_url();?>product/create" method="post" class="form-horizontal" enctype="multipart/form-data">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<div class="row">
								<div class="col-md-6">
									<h3 class="modal-title" id="exampleModalLabel">Create a new Product</h3>
								</div>
								<div class="col-md-6">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
							</div>
						</div>
						<div class="modal-body">
							<div class="row">
								<label for="inputEmail3" class="col-sm-2 control-label">Catagory Name 
									<span class="text-danger">*</span>
								</label>
								<div class="col-sm-4">
									<div class="input-group input-group-md catagory_id">
										<select name="catagory_id" class="form-control">
											<option value="">Select a Catagory</option>
											<?php foreach ($catagory as $value) { ?>
												<option value="<?php echo $value->catagory_id ?>"><?php echo $value->catagory_name ?></option>
											<?php } ?>
										</select>
										<span class="input-group-btn">
											<button type="button" data-toggle="modal" data-target="#cModel" class="btn btn-block btn-primary add_unit"> <i class="fa fa-plus"></i></button>
										</span>
									</div>
								</div>

								<label for="inputEmail3" class="col-sm-2 control-label">Product Name <span class="text-danger">*</span></label>
								<div class="col-sm-4">
									<input type="text" name="product_name" onkeypress="edValueKeyPress()" class="form-control product_name" id="edValue">
								</div>
							</div>
							<br>
							<div class="row">
								<label for="inputEmail3" class="col-sm-2 control-label">Company Name <span class="text-danger">*</span></label>
								<div class="col-sm-4">
									<div class="input-group input-group-md company_id">
										<select name="company_id" id="" class="form-control">
											<option value="">Select a Company</option>
											<?php foreach ($company as $value) { ?>
												<option value="<?php echo $value->company_id ?>"><?php echo $value->company_name ?></option>
											<?php } ?>
										</select>
										<span class="input-group-btn">
											<button type="button" data-toggle="modal" data-target="#comModel" class="btn btn-block btn-primary add_unit"> <i class="fa fa-plus"></i></button>
										</span>
									</div>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Product Model</label>
								<div class="col-sm-4">
									<input type="text" name="product_model" value="" placeholder="N/A" id="nine" autocomplete="off" class="form-control product_model has-success">
								</div>
							</div>
							<br>
							<div class="row">
								<label for="inputEmail3" class="col-sm-2 control-label">Unit Name <span class="text-danger">*</span></label>
								<div class="col-sm-4">
									<div class="input-group input-group-md unit_id">
										<select name="unit_id" id="" class="form-control">
											<option value="">Select a Unit</option>
											<?php foreach ($unit as $value) { ?>
												<option value="<?php echo $value->unit_id ?>"><?php echo $value->unit_name ?></option>
											<?php } ?>
										</select>
										<span class="input-group-btn">
											<button type="button" data-toggle="modal" data-target="#unitModel" class="btn btn-block btn-primary add_unit"> <i class="fa fa-plus"></i></button>
										</span>
									</div>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Product Barcode<span class="text-danger">*</span></label>
								<div class="col-sm-4">
									<div class="input-group input-group-md">
										<?php 
											$data = $last_id['product_id'];
											echo form_input('barcode', $data, 'class= "form-control barcode_id barcode"   placeholder="'.$data.'" id="eight" autocomplete="off"');	
											
										?>
										<span class="input-group-btn">
											<button type="button" class="btn btn-block btn-primary clear_barcode">Clear</button>
										</span>
									</div>
								</div>
								<input type="hidden" name="barcode`" value="<?php echo $data ?>" class="barcode_id1">
							</div>
							<br>
							<div class="row">
								<label for="inputEmail3" class="col-sm-2 control-label">Product Size</label>
								<div class="col-sm-4">
									<?php 
										echo form_input('product_size', '','class ="form-control product_size" placeholder="Product Size" id="seven" autocomplete="off"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Product Image</label>
								<div class="col-md-4">
									<input type="file" placeholder="Profile" id="file" name="file" class="form-control">
								</div>
							</div>
							<br>
							<div class="row">
								<label for="inputEmail3" class="col-sm-2 control-label">Alarm Level</label>
								<div class="col-sm-4">
									<?php 	
										echo form_input('alarming_stock', '0', 'class= "form-control" id="six" autocomplete="off"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Genral / Warranty </label>
								<div class="col-sm-4">
									<select class="select2 form-control" name="product_specification" required="on" id="product_specification">
										<option value="">Select Type</option>
										<option value="1" selected>General</option>
										<option value="2">Warranty</option>
									</select>
								</div>
							</div>
							<br>
							<div class="row">
								<label for="inputEmail3" class="col-sm-2 control-label war_peri" style="display:none;">Warranty Period(In Month)</label>
								<div class="col-sm-4 war_peri" style="display:none;">
									<input type="number" name="product_warranty" class="form-control" placeholder="N/A" id="nine" autocomplete="off">
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label war_peri" style="display:none;">Has Serial No.</label>
								<label class="col-sm-4 checkbox-inline serial_checkbox" style="padding-left: 35px;display:none;">
									<input id="has_serial_no" name="has_serial_no" type="checkbox">Yes
								</label>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-success" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>
							<button type="reset" id="reset_btn" class="btn btn-warning"><i class="fa fa-fw fa-refresh"></i> Reset</button>
						</div>
						</div>
					</div>
				</form>
			</div>
			<!-- Product Category Modal -->
			<div class="modal fade" id="cModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<form id="categoryinsertformproduct" autocomplete="off" action="<?php echo base_url();?>category/create" method="post" class="form-horizontal">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<div class="row">
								<div class="col-md-6">
									<h3 class="modal-title" id="exampleModalLabel">Create a new Category</h3>
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
								<div class="form-group">
									<label class="form-control-label">Category Name <span class="text-danger">*</span></label>
									<input type="text" name="catagory_name" value="" class="form-control" id="catagory_name" placeholder="Category Name" autocomplete="off">
								</div>
								<div class="form-group">
									<label class="form-control-label">Category Description</label>
									<textarea name="catagory_description" cols="10" rows="2" id="catagory_description" class="form-control" maxlength="100" placeholder="Category Description"></textarea>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-success" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>
							<button type="reset" id="reset_btn" class="btn btn-warning"><i class="fa fa-fw fa-refresh"></i> Reset</button>
						</div>
						</div>
					</div>
				</form>
			</div>
			<!-- Product company -->
			<div class="modal fade" id="comModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<form id="conpamyinsertformproduct" autocomplete="off" action="<?php echo base_url();?>company/create" method="post" class="form-horizontal">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<div class="row">
								<div class="col-md-6">
									<h3 class="modal-title" id="exampleModalLabel">Create a new Company</h3>
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
												<input type="text" name="company_name" value="" class="form-control company_name" placeholder="Company Name" autocomplete="off">
											</div>
											<div class="form-group">
												<label for="inputEmail3" class="control-label">Number </label>
												<input type="text" name="company_contact_no" value="" class="form-control company_contact_no" placeholder="Contact Number" autocomplete="off">
											</div>
											<div class="form-group">
												<label for="inputEmail3" class="control-label">Email</label>
												<input type="text" name="company_email" value="" class="form-control company_email text-lowercase" placeholder="Email Address" autocomplete="off">
											</div>
										</div>
										<div class="col-md-6 right">
											<div class="form-group">
												<label for="inputEmail3" class="control-label">Address</label>
												<textarea name="company_address" cols="10" rows="1" class="form-control company_address" maxlength="300" placeholder="Company Address"></textarea>
											</div>
											<div class="form-group">
												<label for="inputEmail3" class="control-label">Description </label>
												<textarea name="company_description" cols="10" rows="1" class="form-control company_description" maxlength="300" placeholder="Company Description"></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-success" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>
							<button type="reset" id="reset_btn" class="btn btn-warning"><i class="fa fa-fw fa-refresh"></i> Reset</button>
						</div>
						</div>
					</div>
				</form>
			</div>
			<!-- Product Unit -->
			<div class="modal fade" id="unitModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<form id="unit" autocomplete="off" action="<?php echo base_url();?>unit/create" method="post" class="form-horizontal">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<div class="row">
								<div class="col-md-6">
									<h3 class="modal-title" id="exampleModalLabel">Create a new unit</h3>
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
										<div class="col-md-12">
											<div class="form-group">
											<label for="inputEmail3" class="control-label">Name <span class="text-danger">*</span></label>
											<input type="text" name="unit_name" value="" class="form-control unit_name" placeholder="Unit Name" autocomplete="off">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-success" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>
							<button type="reset" id="reset_btn" class="btn btn-warning"><i class="fa fa-fw fa-refresh"></i> Reset</button>
						</div>
						</div>
					</div>
				</form>
			</div>
		
	    </div>
    </section>
</div>
