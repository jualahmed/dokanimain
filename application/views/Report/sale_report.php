<div class="content-wrapper" id="vue_app">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Sale Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>Report/all_sale_report_find" class="form-horizontal" method="post" enctype="multipart/form-data" id="salereport" autocomplete="off">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Invoice</label>
								<div class="col-sm-3">
									<input type="text" v-model="invoice_id" class ="form-control one" id="lock" placeholder="Inovice ID" title="Inovice ID" autocomplete="off" autofocus="on">
								</div>

								<label for="inputEmail3" class="col-sm-1 control-label">Company</label>
								<div class="col-sm-3	">
									<select name="" class="form-control" v-model="company_id">
										<option value="0">Select a Company</option>
										<?php foreach ($conpany as $value): ?>
											<option value="<?php echo $value->company_id ?>"><?php echo $value->company_name ?></option>
										<?php endforeach ?>
									</select>
								</div>

								<label for="inputEmail3" class="col-sm-1 control-label">Category</label>
								<div class="col-sm-3">
									<select name="" class="form-control" v-model="category_id">
										<option value="0">Select a Category</option>
										<?php foreach ($category as $value): ?>
											<option value="<?php echo $value->catagory_id ?>"><?php echo $value->catagory_name ?></option>
										<?php endforeach ?>
									</select>
								</div>

								<br><br><br>
								<label for="inputEmail3" class="col-sm-1 control-label">Product</label>
								<div class="col-sm-3">
									<multiselect 
									  	id="ajax" 
									  	:searchable="true"
									  	v-model="selectproduct"
									  	:options="product"
									  	label="product_name"
									  	track-by="product_name"
									  	placeholder="Select a Product"
										@search-change="asyncFind"
										:loading="isLoading"
									  	>
									  	
									  	</multiselect>
								</div>
								
								<label for="inputEmail3" class="col-sm-1 control-label">Customer</label>
								<div class="col-sm-3">
									<select name="" id="" class="form-control" v-model="customer_id">
										<option value="0">Select a Customer</option>
										<?php foreach ($customer_name as $key => $value): ?>
											<option value="<?php echo $value->customer_id ?>"><?php echo $value->customer_name ?></option>
										<?php endforeach ?>
									</select>
								</div>

								<label for="inputEmail3" class="col-sm-1 control-label">Seller</label>
								<div class="col-sm-3">
									<select name="" id="" class="form-control" v-model="seller_id">
										<option value="0">Select a Seller</option>
										<?php foreach ($seller as $var): ?>
											<option value="<?php echo $var->id ?>"><?php echo $var->username ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<br><br><br>
								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-3">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr", 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>

								<label for="inputEmail3" class="col-sm-1 control-label">End</label>
								<div class="col-sm-3">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>

								<label for="inputEmail3" class="col-sm-1 control-label">Sale Type</label>
								<div class="col-sm-3">
									<select name="" id="" class="form-control" v-model="saletype">
										<option value="1">Invoice wise</option>
										<option value="2">Product wise</option>
									</select>
								</div>
								<br><br>
								<div class="col-sm-12 mt-2 text-right">
									<button @click.prevent="result" type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a :href="base_url+'Report/download_data_sale/'+invoice_id+'/'+customer_id+'/'+product_id+'/'+seller_id+'/'+start_date+'/'+end_date" id="down" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
							<br>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</section>
  <div class="text-center" v-if="loding">
    <img src="<?php echo base_url();?>assets/img/LoaderIcon.gif" id="loaderIcon"/>
  </div>
	<section v-else class="content" style="padding-top: 0px;margin-bottom: 35px;">
		<div id="table-scroll" class="table-scroll table-secondary" v-if="alldata.length">          
			<table id="main-table" class="main-table table table-secondary" style="width: 100%;">
				<thead class="table-hf" style="line-height: 0px;">
					<tr>
						<th>NO</th>
						<th>Invoice ID</th>
						<th>Date</th>
						<th v-if="isinvoice!=1">Product Model</th>
						<th v-if="isinvoice!=1">Company</th>
						<th v-if="isinvoice!=1">Catagory</th>
						<th>Customer</th>
						<th>Mobile No</th>
						<th v-if="isinvoice==1">Sale</th>
						<th v-if="isinvoice==1">Discount</th>
						<th v-if="isinvoice==1">Sale return</th>
						<th v-if="isinvoice==1">Delivery</th>
						<th v-if="isinvoice==1">Grand</th>
						<th v-if="isinvoice==1">Paid</th>
						<th v-if="isinvoice==1">Due/Return</th>
						<th style="text-align: center;" v-if="isinvoice!=1">Quantity</th>
						<th style="text-align: right;" v-if="isinvoice!=1" >Buy Price</th>
						<th style="text-align: right;" v-if="isinvoice!=1" >Sale Price</th>
						<th>Seller</th>
						<th v-if="isinvoice==1">Print</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(i,index) in alldata">
						<td>{{ index+1 }}</td>
						<td style="text-align: center;">{{ i.sid }}</td>
						<td>{{ formatDate(i.date_time) }}</td>
						<td v-if="isinvoice!=1" style="white-space: normal!important;">{{ i.product_name }}</td>
						<td v-if="isinvoice!=1">{{ i.company_name }}</td>
						<td v-if="isinvoice!=1">{{ i.catagory_name }}</td>
						<td>{{ i.customer_name }}</td>
						<td>{{ i.customer_contact_no }}</td>
						<td style="text-align: right;" v-if="isinvoice==1">{{ isNaN(parseFloat(i.total_price)) ? '0.00' : parseFloat(i.total_price).toFixed(2) }}</td>
						<td style="text-align: right;" v-if="isinvoice==1">{{ isNaN(parseFloat(i.discount_amount)) ? '0.00' : parseFloat(i.discount_amount).toFixed(2) }}</td>
						<td style="text-align: right;" v-if="isinvoice==1">{{ isNaN(parseFloat(i.sale_return_amount)) ? '0.00' : parseFloat(i.sale_return_amount).toFixed(2) }}</td>
						<td style="text-align: right;" v-if="isinvoice==1">{{ isNaN(parseFloat(i.delivery_charge)) ? '0.00' : parseFloat(i.sale_return_amount).toFixed(2) }}</td>
						<td style="text-align: right;" v-if="isinvoice==1">{{ isNaN(parseFloat(i.grand_total)) ? '0.00' : parseFloat(i.grand_total).toFixed(2) }}</td>
						<td style="text-align: right;" v-if="isinvoice==1">{{ isNaN(parseFloat(i.total_paid)) ? '0.00' : parseFloat(i.total_paid).toFixed(2) }}</td>
						<td style="text-align: right;" v-if="isinvoice==1">{{ calculateDue(i.grand_total, i.total_paid) }}</td>
						<th style="text-align: center;" v-if="isinvoice!=1">{{ i.sale_quantity }}</th>
						<td style="text-align: right;" v-if="isinvoice!=1">{{ isNaN(parseFloat(i.unit_buy_price)) ? '0.00' : parseFloat(i.unit_buy_price).toFixed(2) }}</td>
						<td style="text-align: right;" v-if="isinvoice!=1">{{ isNaN(parseFloat(i.actual_sale_price)) ? '0.00' : parseFloat(i.actual_sale_price).toFixed(2) }}</td>
						<td>{{ i.username }}</td>
						<td v-if="isinvoice==1"><a :href="base_url+'invoice/index/'+i.sid" target="_blank" class="btn btn-secondary">Print</a></td>
					</tr>
					<tr v-if="saletype == 2">
						<td colspan="8"></td>
						<td><b>Total: {{ quantity }}</b></td>
						<td class="text-right"><b>Total: {{ parseFloat(amount).toFixed(2) }}</b></td>
						<td class="text-right"><b>Total:{{ parseFloat(samount).toFixed(2) }}</b></td>
						<td></td>
					</tr>
					<tr v-else>
						<td colspan="5" class="text-right">Total: </td>
						<td class="text-right"><b> {{ parseFloat(total_sale).toFixed(2) }}</b></td>
						<td class="text-right"><b> {{ parseFloat(total_discount).toFixed(2) }}</b></td>
						<td class="text-right"><b> {{ parseFloat(total_sale_return).toFixed(2) }}</b></td>
						<td class="text-right"><b> {{ parseFloat(total_delivery).toFixed(2) }}</b></td>
						<td class="text-right"><b> {{ parseFloat(total_grand).toFixed(2) }}</b></td>
						<td class="text-right"><b> {{ parseFloat(total_paid).toFixed(2) }}</b></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div v-else>
			<h2 class="text-danger text-center">Result is Empty</h2>
		</div>
	</section>
</div>
