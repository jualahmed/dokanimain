<?php 
	$this->load->config('custom_config'); 
	$value_added_tax = $this->config->item('VAT');
	$allow_negative_stock = $this->config->item('allow_negative_stock');
	$tp_price_purchase = $this->config->item('tp_price_purchase');
	$tp_price_vat_purchase = $this->config->item('tp_price_vat_purchase');
?>
<div class="content-wrapper">
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
			            				  :close-on-select="true" :options-limit="300" :limit="3" :limit-text="limitText" :max-height="600" :show-no-results="false" :hide-selected="false">
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
			            			<td id="receiptid">
			            				{{ selected1.receipt_id }}
			            			</td>
			            			<td>
			            				<b>Purchase Date</b>
			            			</td>
			            			<td>
			            				{{ selected1.receipt_date }}
			            			</td>
			            		</tr>
			            		<tr>
			            			<td><b>Purchase Price</b></td>
			            			<td>
			            				{{ selected1.purchase_amount }}
			            			</td>
			            			<td><b>Discount</b></td>
			            			<td>
			            				{{ selected1.gift_on_purchase }}
			            			</td>
			            		</tr>
			            		<tr>
			            			<td><b>Grand Total</b></td>
			            			<td>
			            				{{ selected1.final_amount }}
			            			</td>
			            			<td><b>Transport Cost</b></td>
			            			<td>
			            				{{ selected1.transport_cost }}
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
			            			<td>
			            				
			            			</td>
			            			<td><b>Discount</b></td>
			            			<td>
			            				
			            			</td>
			            		</tr>
			            		<tr>
			            			<td><b>Grand Total</b></td>
			            			<td>
			            				
			            			</td>
			            			<td><b>Transport Cost</b></td>
			            			<td>
			            			</td>
			            		</tr>
			            	</tbody>
			            </table>
						<br>
						
						<div class="row">
							<div class="col-md-6"></div>
							<div class="col-sm-6">
								<div>
								  <multiselect v-model="selectedCountries" id="ajax" label="product_name" track-by="product_name" placeholder="search product by name" open-direction="bottom" :options="countries" :searchable="true" :loading="isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="true" :options-limit="300" :limit="3" :limit-text="limitText" :max-height="600" :show-no-results="false" :hide-selected="false" @search-change="asyncFind">
								    <template slot="tag" slot-scope="{ option, remove }"><span class="custom__tag"><span>{{ option.product_name }}</span><span class="custom__remove" @click="remove(option)">❌</span></span></template>
								    <template slot="clear" slot-scope="props">
								      <div class="multiselect__clear" v-if="selectedCountries && selectedCountries.length" @mousedown.prevent.stop="clearAll(props.search)"></div>
								    </template><span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
								  </multiselect>
								</div>
							</div>
						</div>
	
						<input type="hidden" id="" >
		              	<br>
		              	<form id="product_listing_form">
			              	<table class="table table-bordered reduce_space">
			              		<tbody>
			              			<tr>
			              				<td>
			              					<b>Quantity:</b>
			              				</td>
			              				<td>
			              					<input type="" class="form-control custom_form_control quantity" v-model="quantity" id="quantity" name="" placeholder="Ex: 10" autocomplete="off" required>
			              				</td>
			              				<td style="width: 25%; vertical-align: middle;">Expire Date:</td>
			              				<td>
			              					<input type="text" id="datepicker" class="form-control custom_form_control" v-model="expiredate" name="" placeholder="Ex: 14-12-2016" autocomplete="off">
			              				</td>
			              			</tr>
									<?php 
										if($tp_price_purchase!=0 && $tp_price_vat_purchase!=0)
										{
									?>
									<tr>
			              				<td style="width: 25%; vertical-align: middle;" >
			              				 <b>TP:</b>
			              				</td>
			              				<td>
			              					<input type="" class="form-control custom_form_control tp_total" v-model="tp_total" style="text-align: right;" id="tp_total" name="" placeholder="Ex: 10" autocomplete="off">
			              				</td>
			              				<td style="width: 25%; vertical-align: middle;">VAT:</td>
			              				<td>
			              					<input type="" class="form-control custom_form_control vat_total" v-model="vat_total" style="text-align: right;" id="vat_total" name="" placeholder="Ex: 10" autocomplete="off">
			              				</td>
			              			</tr>
										<?php } ?>
			              			<tr>
			              				<td style="vertical-align: middle;">
			              					Total Buy Price:
			              				</td>
			              				<td>
			              					<input  class="form-control custom_form_control total_buy_price" v-model="total_buy_price" style="text-align: right;">
			              				</td >
			              				<td style="vertical-align: middle;">General Sale Price:</td>
			              				<td style="text-align: right;">
			              					<input type="" class="form-control custom_form_control" v-model="general_sale_price" style="text-align: right;" placeholder="Ex: 15" autocomplete="off" required>
			              				</td>
			              			</tr>

			              			<tr>
			              				<td style="vertical-align: middle;">
			              					Unit Buy Price:
			              				</td>
			              				<td>
			              					<input type="" class="form-control custom_form_control" v-model="unit_buy_price_purchase" style="text-align: right;" placeholder="Ex: 10" autocomplete="off">
			              				</td>
			              				<td style="width: 20%; vertical-align: middle;">Exclusive Sale Price:</td>
			              				<td>
			              					<input type="" class="form-control custom_form_control" v-model="exclusive_sale_price" style="text-align: right;" autocomplete="off" placeholder="Ex: 12">
			              				</td>
			              			</tr>
			              		</tbody>
			              	</table>
							<div class="box-footer" style="background: #0f77ab;">
								<center>
									<div class="col-sm-22">
										<button v-if="(selectedCountries && (selectedCountries.product_warranty==0 || allworrantyproduct.length==quantity) && selected1 && selectedCountries.product_id && quantity && exclusive_sale_price && general_sale_price)" type="button" @click="submit" class="btn btn-success btn-sm" name="search_random" id="submit"><i class="fa fa-fw fa-save"></i> Create</button>
										<button v-else type="button" @click="submit" class="btn btn-success btn-sm" name="search_random" id="submit" disabled><i class="fa fa-fw fa-save"></i> Create</button>
										<button type="reset" id="reset" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
										<button type="button" id="delete_purchase_invoice" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Delete</button>
									</div>
								</center>
							</div>
		              	</form>
		              	<ul class="list-group" v-if="selectedCountries && selectedCountries.product_warranty>0">
		              		<li class="list-group-item" v-for="i in quantity"><b>Serial no:</b> <input v-model="allworrantyproduct[i-1]" style="display: inline;width:80%;" type="text" class="form-control" placeholder="Serial no"></li>
		              	</ul>
		            </div>
		        </div>
	      	</div>
			
	      	<div class="col-md-6" style="padding: 0px;">
		        <div class="box">
		            <div class="box-body">
			            <div class="wrap">
							<table class="head">
								<tr style="background-color: #2aabd2; color: white;">
									<td style="width: 4%;">No</td>
									<td style="width: 6%;">Pr. ID</td>
									<td style="text-align: left; width: 35%;">Product Name</td>
									<td style="text-align: center; width: 6%;">Qnt.</td>
									<td style="text-align: center;width: 10%;">U.BP</td>
									<td style="text-align: center; width: 10%;">TP.</td>
									<td style="text-align: center; width: 7%;" ><i class="fa fa-fw fa-wrench"></i></td>
									<td style="text-align: center; width: 7%;" ><i class="fa fa-edit"></i></td>
								</tr>
								<tr v-for="(p,index) in purchase_info[0]">
									<td style="width: 4%;">{{ index+1 }}</td>
									<td style="width: 6%;">{{ p.purchase_id }}</td>
									<td style="width: 35%;">{{ p.product_name }}</td>
									<td style="text-align: center; width: 6%;">{{ p.purchase_quantity }}</td>
									<td style="text-align: center;width: 10%;">{{ p.unit_buy_price }}</td>
									<td style="text-align: center;width: 10%;">{{ p.purchase_quantity*p.unit_buy_price }}</td>
									<td style="text-align: center; width: 7%;" ><i class="fa fa-fw fa-wrench"></i></td>
									<td style="text-align: center; width: 7%;" ><i class="fa fa-edit"></i></td>
								</tr>
								<tr  style="background-color: #2aabd2; color: white;">
										<td style="width: 4%;"></td>
										<td style="width: 6%;"></td>
										<td style="width: 35%;text-align: right;">Total</td>
										<td style="width: 6%;text-align: center;">{{ totalqty }}</td>
										<td style="text-align: center; width: 10%;"></td>
										<td style="text-align: center;width: 10%;">{{ tunit_buy_price }}</td>
										<td style="text-align: center;width: 10%;"><span id="total_purchase_price_new_final"></span></td>
										<td style="text-align: center; width: 7%;" ></td>
									</tr>
							</table>
						</div>
		            </div>
		        </div>
	      	</div>
			

	      <!-- Start: Modal -->
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
		              	<table class="table table-bordered serial_qnt_price" style="display:none;">
		              		<tr>
		              			<td style="vertical-align: middle;">Quantity: </td>
		              			<td>
		              				<input type="text" class="form-control" id="qty" style="text-align: right;" placeholder="Ex: 100" required="on" autocomplete="off">
		              				<input type="hidden" class="form-control" id="pro_hide" style="text-align: right;" placeholder="Ex: 100" required="on" autocomplete="off">
		              				<input type="hidden" class="form-control" id="pro_hide_buy" style="text-align: right;" placeholder="Ex: 100" required="on" autocomplete="off">
		              			</td>
		              		</tr>
		              		<tr>
		              			<td style="vertical-align: middle;">Unit Buy Price: </td>
		              			<td>
		              				<input type="text" class="form-control" id="u_b_p" style="text-align: right;" placeholder="Ex: 10" required="on" autocomplete="off">
		              			</td>
		              		</tr>
		              	</table>
						<div class="inner_table_2 pro_serial_input_for_edit" style="display:none;">

							<table class="table table-bordered pro_serial_input_for_edit_new" id="pro_serial_input_for_edit">
							</table>
						</div>
		              </div>
		              <div class="modal-footer">
		                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		                <input type="submit" class="btn btn-info" id="save_change" style="display:none;" value="Save">
		              </div>
		            </div>
		            <!-- modal-content -->
	            </form>
	          </div>
	          <!-- modal-dialog -->
	       </div>
	      <!-- End: Modal -->

	    </div>
    </section>
</div>

<div class="modal fade" id="show_product_add_modal" >
	<div class="modal-dialog" style="width:1000px;">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title"><i class="fa fa-plus"></i> Add New Product</h4>
			</div>
			<form id="add_product_form" action="<?php echo base_url(); ?>setup/create_new_product" method="post" autocomplete="off" enctype="multipart/form-data" role="form" class="form-horizontal">
				<div class="modal-body" style="padding: 0px;">
					<div class="col-md-12">
						<div class="box-body">	
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Catagory Name</label>
								<div class="col-sm-4">
									<?php 	
										echo form_dropdown('catagory_name', $catagory_name, '' ,'class="form-control select2 catagory_name" id="catagory_name" style="width: 100%;"tabindex="-1" aria-hidden="true" required="required"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Custom Name</label>
								<div class="col-sm-4">
									<?php 
										echo form_input('customProductName', '','class ="form-control" id="edValue" onKeyPress="edValueKeyPress()" onKeyUp="edValueKeyPress()" onBlur="checkAvailability()" style="text-transform:uppercase" placeholder="Product New Name" autocomplete="off"');
										
									?>
									<span id="user-availability-status1" style="display:none;"></span>
									<span id="user-availability-status2" style="display:none;"></span>
									<p><img src="<?php echo base_url();?>assets/assets2/LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Company Name</label>
								<div class="col-sm-4">
										<?php 	
											echo form_dropdown('company_name', $company_name, '' ,'class="form-control select2 company_name" id="company_name" style="width: 100%;"tabindex="-1" aria-hidden="true" required="required"');
										?>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Unit Name</label>
								<div class="col-sm-4">
									<?php 	
										echo form_dropdown('unit_name', $unit_name, '' ,'class="form-control select2 unit_name" style="width: 100%;"tabindex="-1" aria-hidden="true" required="required" id="unit_name"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Alarm Level</label>
								<div class="col-sm-4">
									<?php 	
										echo form_input('alarming_stock', '0', 'class= "form-control" id="alarming_stock" autocomplete="off"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Product Size</label>
								<div class="col-sm-4">
									<?php 
										echo form_input('product_size', '','class ="form-control" placeholder="Product Size" id="product_size" autocomplete="off"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Product Barcode</label>
								<div class="col-sm-4">
									<?php 
										$data = $last_id['product_id'];
										echo form_input('barcode', $data, 'class= "form-control barcode_id"  style="text-transform:uppercase" placeholder="'.$data.'" id="barcode_id" autocomplete="off"');	
									?>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Product Model</label>
								<div class="col-sm-4">
									<?php 
										echo form_input('product_model', '','class ="form-control" placeholder="N/A" id="product_model" autocomplete="off"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Genral / Warranty </label>
								<div class="col-sm-4">
									<select class="select2 form-control" name="product_specification" style="width:100%;" required="on" id="prospec">
										<option value="">Select Type</option>
										<option value="1" selected>General</option>
										<option value="2">Warranty</option>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label war_peri">Warranty Period(In Month)</label>
								<div class="col-sm-4 war_peri">
									<input type="number" name="product_warranty" class="form-control" placeholder="N/A" id="nine" autocomplete="off">
								</div>
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


