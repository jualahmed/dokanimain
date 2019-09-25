<div class="content-wrapper" id="vuejsapp">
	<section class="content">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Damage Setup</h3>
					</div>
					<form id="damage_product" class="form-horizontal" action="<?php echo base_url();?>damageproduct/create" method="post" autocomplete="off">
						<div class="box-body">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Product <span class="text-danger">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control product_name" title="Product Name" name="product_name" id="lockk3" placeholder="Product Name" autofocus="on">
									<input type="hidden" id="pro_id" name="pro_id">
								</div>
							</div>
							<br>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Buy <span class="text-danger">*</span></label>
								<div class="col-sm-2">
									<input type="text" class="form-control buy_price" title="Product Name" name="buy_price" id="buy" placeholder="Buy" readonly>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Sale</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" title="Product Name" name="sale" id="sale" placeholder="Sale" readonly>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Stock</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" title="Product Name" name="stock" id="stock" placeholder="Stock" readonly>
								</div>
							</div>
							<br>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Damage <span class="text-danger">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control damage_quantity" title="Product Name" name="damage_quantity" id="product_quantity" placeholder="Damage Quantity">
								</div>
							</div>
						</div>
						<div class="box-footer text-right">
							<button type="submit" class="btn btn-success" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>

						</div>
					</form>
				</div>
			</div>
		</div>
		<table class="table table-bordred table-striped" align="left">
			<tr align="left">
				<th>No.</th>
				<th>Product name</th>
				<th>Damage Quantity</th>
				<th>Unit Buy Pprice</th>
				<th align="center">Action</th>
			</tr>
			<tr v-for="(r,index) in result[0]" align="left"> 
				<td>{{ index+1 }}</td>
				<td>{{ r.product_name }}</td>
				<td>{{ r.damage_quantity }}</td>
				<td>{{ r.unit_buy_price }}</td>
				<td>
					<!-- <a data-toggle="modal" :company_id="r.company_id" data-target="#EditModel" class="btn edit btn-sm btn-success" ><i class="fa fa-edit"></i> Edit</a> -->
					<a onclick="return confirm('Are you sure your want to delete?')" :href="base_url+'damageproduct/destroy/'+r.damage_id" class="btn btn-sm btn-danger" >
						<i class="fa fa-trash"></i> Delete
					</a>
				</td>
			</tr>
		</table>
		<div id='pagination' v-html="pagination[0]"></div>
	</section>
</div>