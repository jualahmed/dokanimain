<div class="content-wrapper" id="vueapp">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
			  <div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Motorcycle Stock Report</h3>
						<h3 class="box-title"> ( Total Stock Amount: <?php echo sprintf("%.2f",$total_stock_price);?> )</h3>
						<h3 class="box-title"> ( Stock Quantity: <?php echo $total_stock_quantity;?> )</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>Report/all_stock_report_find" class="form-horizontal" method="post" id="form_2" autocomplete="off">
							<div class="form-group">
							  <label for="inputEmail3" class="col-sm-1 control-label">Product</label>
							  <div class="col-sm-2">
									<select name="product_id" class="form-control" v-model="product_id">
										<option value="0">Select a Product</option>
										<?php foreach ($product as $key => $value): ?>
											<option value="<?php echo $value->product_id ?>"><?php echo $value->product_name ?></option>
										<?php endforeach ?>
									</select>
							  </div>
							  <label for="inputEmail3" class="col-sm-1 control-label">Category</label>
							  <div class="col-sm-2">
									<select name="catagory_id" class="form-control" v-model="catagory_id">
										<option value="0">Select a Category</option>
										<?php foreach ($catagory as $key => $value): ?>
											<option value="<?php echo $value->catagory_id ?>"><?php echo $value->catagory_name ?></option>
										<?php endforeach ?>
									</select>
							  </div>
							  <label for="inputEmail3" class="col-sm-1 control-label">Company</label>
							  <div class="col-sm-2">
									<select name="company_id" v-model="company_id" id="" class="form-control">
										<option value="0">Select a Company</option>
										<?php foreach ($company as $key => $var): ?>
											<option value="<?php echo $var->company_id ?>"><?php echo $var->company_name ?></option>
										<?php endforeach ?>
									</select>
							  </div>
							</div>
							<br>
							<div class="form-group">
								  <label for="inputEmail3" class="col-sm-1 control-label">Type<span>*</span></label>
								  <div class="col-sm-2">
										<select class="form-control select2" name="type_wise" v-model="type" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" id="type_wise" tabindex="-1" aria-hidden="true" required>
											<option value="0">Select Type</option>
											<option value="available">Available Stock</option>
											<option value="not_available">Not Available Stock</option>
											<option value="all">All Stock</option>
										</select>
								  </div>
								  <label for="inputEmail3" class="col-sm-1 control-label">Amount</label>
								  <div class="col-sm-2">
										<?php 
											echo form_input('product_amount','','class ="form-control seven" id="lock77" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" placeholder="Stock Amount" title="Stock Amount" autocomplete="off"');
										?>
								  </div>
								<div class="col-sm-4 mt-2">
									<button type="submit" class="btn btn-success btn-sm" @click.prevent="stockreport" name="search_random"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a :href="base_url+'Report/stock_report_print/'+catagory_id+'/'+product_id+'/'+company_id+'/'+type" id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration:none;"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="modal preload" style="display: none">
		<div class="center">
			<img src="<?php echo base_url();?>assets/assets2/spin.gif" id="loaderIcon"/>
		</div>
	</div>
	<table class="table table-secondary" v-if="alldata.length>0">
		<tr>
			<th>No.</th>
			<th>Product.</th>
			<th>Stock.</th>
			<th>BP.</th>
			<th>SP.</th>
		</tr>
		<tr v-for="(d,index) in alldata">
			<td>{{ index+1 }}</td> 
			<td>{{ d.product_name }}</td>
			<td>{{ d.stock_amount }}</td>
			<td>{{ d.bulk_unit_buy_price }}</td>
			<td>{{ d.general_unit_sale_price }}</td>
		</tr>
		<tr>
			<td colspan="2"><b></b></td>
			<td colspan="1"><b>Total Quantity: {{ stockqty }}</b> </td>
			<td colspan="1"><b>Total Stock Amount: {{ amount }}</b></td>
			<td colspan="1"><b>Total Sale Amount: {{ samount }}</b></td>
		</tr>
	</table>
	<h2 class="text-danger text-center" v-else>Result is Empty</h2>
</div>
