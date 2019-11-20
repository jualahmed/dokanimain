<div class="content-wrapper" id="vuejsapp">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				 <div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Purchase Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>Report/all_purchase_report_find" method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" id="form_3">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Challan No</label>
								<div class="col-sm-2">
									<select name="catagory_id" class="form-control" v-model="receipt">
										<option value="0">Select a purchase receipt</option>
										<?php foreach ($purchase_receipt as $key => $value): ?>
											<option value="<?php echo $value->receipt_id ?>"><?php echo $value->distributor_name ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Product</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" v-model="product" name="product_name" id="lock22" placeholder="Product Name">
									<input type="hidden" name="product_id" id="pro_id">
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Catagory</label>
								<div class="col-sm-2">
									<select name="catagory_id" class="form-control" v-model="category">
										<option value="0">Select a Category</option>
										<?php foreach ($catagory as $key => $value): ?>
											<option value="<?php echo $value->catagory_id ?>"><?php echo $value->catagory_name ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Company</label>
								<div class="col-sm-2">
									<select name="company_id" id="" class="form-control" v-model="company">
										<option value="0">Select a Company</option>
										<?php foreach ($company as $key => $var): ?>
											<option value="<?php echo $var->company_id ?>"><?php echo $var->company_name ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<br>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Distributor</label>
								<div class="col-sm-2">
									<select name="company_id" id="" class="form-control" v-model="distributor_id">
										<option value="0">Select a Distributor</option>
										<?php foreach ($distributor_info as $key => $var): ?>
											<option value="<?php echo $var->distributor_id ?>"><?php echo $var->distributor_name ?></option>
										<?php endforeach ?>
									</select>
								</div>
									<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control", 'id' => "datepickerrr", 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">End</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>
								<div class="col-sm-12 mt-2 text-right">
									<button type="submit" @click.prevent="purchase_report" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a :href="base_url+'Report/download_data_purchase/'+receipt+'/'+product+'/'+category+'/'+company+'/'+distributor_id+'/'+start_date+'/'+end_date" id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration:none;"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="content-3" id="infomsg">
		<div class="row">
			<div class="col-md-12">
				<div id="table-scroll" class="table-scroll table-secondary table-responsive" v-if="alldata.length>0">
					<table id="main-table" class="main-table table table-secondary" style="width: 100%;">
						<thead class="table-hf" style="line-height: 0px;">
							<tr>
							  <th>No</th>
							  <th>Date</th>
							  <th title="Receipt ID">R.ID</th>
							  <th>Company</th>
							  <th>Category</th>
							  <th>Product</th>
							  <th title="Purchase Quantity">Quantity</th>
							  <th>BP</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(a,index) in alldata">
							  <td>{{index+1}}</td>
							  <td>{{formatDate(a.receipt_date)}}</td>
							  <td title="Receipt ID">{{ a.receipt_id }}</td>
							  <td>{{ a.company_name }}</td>
							  <td>{{ a.catagory_name }}</td>
							  <td>{{ a.product_name }}</td>
							  <td title="Purchase Quantity">{{ a.purchase_quantity }}</td>
							  <td>{{ a.unit_buy_price }}</td>
							</tr>
							<tr>
								<td colspan="6"><b></b></td>
								<td colspan="1"><b>Total Quantity: {{ stockqty }}</b> </td>
								<td colspan="1"><b>Total Stock Amount: {{ samount }}</b></td>
							</tr>
						</tbody>
					</table>
				</div>
				<h2 v-else class="text-danger text-center">Result Empty</h2>
			</div>
		</div>	
	</section> 
</div>