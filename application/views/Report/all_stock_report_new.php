<style>
	.multiselect {
		min-height: 38px !important;
	}

	.multiselect__tags {
		min-height: 38px !important;
	}
</style>
<div class="content-wrapper" id="vueapp">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Stock Report</h3>
						<h3 class="box-title"> ( Total Stock Value: <?php echo number_format($total_stock_price, 2); ?> )</h3>
						<h3 class="box-title"> ( Stock Quantity: <?php echo number_format($total_stock_quantity, 2); ?> )</h3>
					</div>
					<div class="box-body">
						<form action="<?php echo base_url(); ?>Report/all_stock_report_find" class="form-horizontal" method="post" id="form_2" autocomplete="off">
							<div class="form-group row" style="margin-bottom: 20px !important;">
								<label for="inputEmail3" class="col-sm-1 control-label">Product</label>
								<div class="col-sm-6">

									<multiselect 
										id="ajax" 
										:searchable="true" 
										v-model="selectproduct" 
										:options="product" 
										label="product_name" 
										track-by="product_name" 
										placeholder="Select a Product" 
										@search-change="asyncFind" 
										@open="asyncFind"
										:loading="isLoading"
										:selectLabel="'Select'">
									</multiselect>

								</div>

								<label for="inputEmail3" class="col-sm-1 control-label">Category</label>
								<div class="col-sm-4">
									<select name="catagory_id" class="form-control" v-model="catagory_id">
										<option value="0">Select a Category</option>
										<?php foreach ($catagory as $key => $value) : ?>
											<option value="<?php echo $value->catagory_id ?>"><?php echo $value->catagory_name ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-1 control-label">Company</label>
								<div class="col-sm-2">
									<select name="company_id" v-model="company_id" id="" class="form-control">
										<option value="0">Select Company</option>
										<?php foreach ($company as $key => $var) : ?>
											<option value="<?php echo $var->company_id ?>"><?php echo $var->company_name ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Size</label>
								<div class="col-sm-2">
									<?php
									echo form_input('product_size', '', 'v-model="product_size" class ="form-control seven" id="lock77" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" placeholder="Product Size" autocomplete="off"');
									?>
								</div>

								<label for="inputEmail3" class="col-sm-1 control-label">Model</label>
								<div class="col-sm-2">
									<?php
									echo form_input('product_model', '', 'v-model="product_model" class ="form-control seven" id="lock77" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" placeholder="Product Model" autocomplete="off"');
									?>
								</div>

								<label for="inputEmail3" class="col-sm-1 control-label">Type<span>*</span></label>
								<div class="col-sm-2">
									<select class="form-control select2" name="type_wise" v-model="type_wise" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" id="type_wise" tabindex="-1" aria-hidden="true" required>
										<option value="0">Select Type</option>
										<option value="all">All Stock</option>
										<option value="available">Available Stock</option>
										<option value="not_available">Not Available Stock</option>
										<option value="alarming_stock">Alarming Stock</option>
									</select>
								</div>
							</div>
							<div class="form-group" style="margin-top: 20px;">
								<div style="float: right;">
									<button type="submit" class="btn btn-success btn-sm" @click.prevent="stockreport" name="search_random"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a @click.prevent="downloadLink" role="button" href="" id="down" class="btn btn-primary btn-sm" style="text-decoration:none;"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="text-center" v-if="loding">
		<img src="<?php echo base_url(); ?>assets/img/LoaderIcon.gif" id="loaderIcon" />
	</div>

	<section class="content">
		<div id="table-scroll" class="table-scroll table-responsive table-secondary" v-if="alldata.length">
			<table id="main-table" style="min-width: 1200px;" class="main-table table table-secondary" v-if="alldata.length>0">
				<thead class="table-hf" style="line-height: 0px;">
					<tr>
						<th>No.</th>
						<th width="20%">Product.</th>
						<th>Category</th>
						<th>Company</th>
						<th>Product Size</th>
						<th>Product Model</th>
						<th align="center">Stock.</th>
						<th align="right">Buy Price</th>
						<th align="right">Total BP</th>
						<th align="right">Sale Price</th>
						<th align="right">Total SP</th>
						<th align="right">MRP</th>
						<th align="right">Total MRP</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(d,index) in alldata">
						<td>{{ index+1 }}</td>
						<th width="20%" style="white-space: normal!important;">{{ d.product_name }}</th>
						<td style="white-space: normal!important;">{{ d.catagory_name }}</td>
						<td style="white-space: normal!important;">{{ d.company_name }}</td>
						<td style="white-space: normal!important;">{{ d.product_size }}</td>
						<td style="white-space: normal!important;">{{ d.product_model }}</td>
						<td class="text-center">{{ d.stock_amount }}</td>
						<td class="text-right">{{ d.bulk_unit_buy_price | shortFloatNumber }}</td>
						<td class="text-right">{{ d.bulk_unit_buy_price * d.stock_amount | shortFloatNumber }}</td>

						<td class="text-right">{{ d.bulk_unit_sale_price | shortFloatNumber }}</td>
						<td class="text-right">{{ d.bulk_unit_sale_price * d.stock_amount | shortFloatNumber }}</td>

						<td class="text-right">{{ d.general_unit_sale_price | shortFloatNumber }}</td>
						<td class="text-right">{{ d.general_unit_sale_price * d.stock_amount | shortFloatNumber }}</td>
					</tr>
					<tr>
						<td colspan="6"><b>Total</b></td>
						<td class="text-center"><b>{{ stockqty }}</b> </td>
						<td></td>
						<td class="text-right"><b>{{ amount | shortFloatNumber }}</b></td>
						<td></td>
						<td class="text-right"><b>{{ samount | shortFloatNumber }}</b></td>
						<td></td>
						<td class="text-right"><b>{{ mrp | shortFloatNumber }}</b></td>
					</tr>
				</tbody>
			</table>
		</div>
		<h2 class="text-danger text-center" v-else>Result is Empty</h2>
	</section>
</div>