<div class="content-wrapper" id="vue_app">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Quotation Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>Report/all_sale_report_find" class="form-horizontal" method="post" enctype="multipart/form-data" id="salereport" autocomplete="off">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Quotation</label>
								<div class="col-sm-3">
									<input type="text" v-model="quotation_id" class ="form-control one" id="lock" placeholder="Quotation ID" title="Quotation ID" autocomplete="off" autofocus="on">
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
								<br><br>
								<div class="col-sm-12 mt-2 text-right">
									<button @click.prevent="result" type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
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
	<section v-else class="content" style="padding-top: 0px;">
		<div id="table-scroll" class="table-scroll table-secondary" v-if="alldata.length">          
			<table id="main-table" class="main-table table table-secondary" style="width: 100%;">
				<thead class="table-hf" style="line-height: 0px;">
					<tr>
						<th>NO</th>
						<th>Quotation ID</th>
						<th>Date</th>
						<th>Customer</th>
						<th>Mobile No</th>
						<th style="text-align:right">Price</th>
						<th style="text-align:right">Discount</th>
						<th style="text-align:right">Deliver Charge</th>
						<th style="text-align:right">Vat</th>
						<th style="text-align:right">Grand</th>
						<th>Seller</th>
						<th style="text-align:center">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(i,index) in alldata">
						<td>{{ index+1 }}</td>
						<td align="center">{{ i.quotation_id }}</td>
						<td>{{ formatDate(i.created_at) }}</td>
						<td>{{ i.customer_name }}</td>
						<td>{{ i.customer_contact_no }}</td>
						<td align="right">{{ i.quotation_total_price }}</td>
						<td align="right">{{ i.quotation_discount_amount }}</td>
						<td align="right">{{ i.quotation_delivery_charge }}</td>
						<td align="right">{{ i.quotation_vat }}</td>
						<td align="right">{{ i.quotation_grand_total }}</td>
						<td>{{ i.username }}</td>
						<td style="text-align:center">
							<a :href="base_url+'sale/printQuotation/'+i.qid" target="_blank" class="btn btn-sm"><i class="fa fa-print"></i></a>
							<button type="button" @click="deleteQuotation(i.qid)" class="btn btn-sm"><i class="fa fa-trash"></i></button>
							<button @click="quotationToSale(i.qid)" class="btn btn-sm"><i class="fa fa-shopping-cart"></i></button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div v-else>
			<h2 class="text-danger text-center">Result is Empty</h2>
		</div>
	</section>
</div>
