<div class="content-wrapper">
	<?php
		if (!defined('BASEPATH')) exit('No direct script access allowed');
		$productId = array(
			'name'	=> 'productId',
			'id'	=> 'productId',
			'value' => set_value('productId'),
			'maxlength'	=> 49,
			'tabindex' => 1
		);
		$productName = array(
			'name'	=> 'productName',
			'id'	=> 'product_id',
			'value' => set_value('product_id'),
			'maxlength'	=> 49,
			'tabindex' => 1
		);
		$Quantity = array(
			'name'	=> 'Quantity',
			'id'	=> 'Quantity',
			'value' => set_value('Quantity'),
			'maxlength'	=> 149,
			'tabindex' => 4
		);
	?>
	<?php 
		if($status != '' )
		{
			 if($status == "exists")
			 {
				 echo '<div class="alert alert-warning alert-dismissible" style="background:#f39c12;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i> Already Exist</h4>
					</div>';
			 }
			 else if($status == "successful")
			 {
				 echo '<div class="alert alert-success alert-dismissible" style="background:#00a65a;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i> Success</h4>
					</div>';
			 }
			 else if($status == "failed")
			 {
				 echo '<div class="alert alert-danger alert-dismissible" style="background:#dd4b39;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i> Failed</h4>
					</div>';
			 }
			 else{
				 
				 echo validation_errors();
			 }
		}
	?>
<section>
	<br>
	<div class="row">
		<div class="col-md-12">
		  <div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><p>Search Barcode &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; If New Barcode Print, At First Click " <b style="color:#15d1da;">DELETE ALL</b> " Button.</p></h3>
			</div>
			<div class="box-body">
			<form action ="<?php echo base_url();?>product/search_barcode_barcode" method="post" id="form_22" class="form-horizontal">
				<div class="form-group">
				  <label for="inputPassword3" class="col-sm-1 control-label">Product</label>
				  <div class="col-sm-3">
				  		<select name="" id="" class="form-control" onchange="document.location.href=this.options[this.selectedIndex].value;">
				  			<option value="">Select  Product</option>
				  			<?php foreach ($product_info as $key => $var): ?>
				  				<option value="<?php echo base_url().'product/searchBarcode/'.$var->product_id ?>"><?php echo $var->product_name ?></option>
				  			<?php endforeach ?>
				  		</select>
                  	</div>
                    <label for="inputPassword3" class="col-sm-2 control-label">Warranty product</label>
					  <div class="col-sm-3">
	                    <select name="" id="" class="form-control" onchange="document.location.href=this.options[this.selectedIndex].value;">
	                    	<option value="">Select a Peoduct</option>
	                    	<?php foreach ($w_product_info as $key => $var): ?>
	                    		<option value="<?php echo base_url().'product/warrantyproductprint/'.$var->ip_id ?>"><?php echo $var->product_name ?>( <?php echo $var->sl_no ?> )</option>
	                    	<?php endforeach ?>
	                    </select>
	                  </div>
                </div>
				<div class="box-footer">
					<center>
						<div class="col-sm-22">
							<button type="submit" class="btn btn-success" name="search_random" style="width:100px;"><i class="fa fa-fw fa-save"></i> Submit</button>
							<button type="reset" id="reset_btn" class="btn btn-warning" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
						</div>
					</center>
				</div>
			</form>
			</div>
		</div>
	</div>
</section>
	<?php
	if($this -> uri -> segment(3) || $product_type =='bulk' || $product_type =='individual')
	{
	?>
<section>
	<div class="row">
		<div class="col-md-12">
			<div class="box">	 
				<div class="box-body">
					<?php 
						echo form_open($this->uri->uri_string());
						echo form_hidden('product_id', $this -> uri -> segment(3));
						echo form_hidden('unit_sale_price', $sale_price);
						echo form_hidden('general_sale_price', $general_sale_price);
						echo form_hidden('PRODUCT_NAME', $product_name);
						echo form_hidden('special_for_individual',true);
						
					?>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-1 control-label">Quantity</label>
						<div class="col-sm-3">
							<?php
								echo form_input($Quantity ,'',' placeholder="Ex : 5" class ="form-control-2" style="color:gray;"');
								echo form_error($Quantity['name'],'<div style="height:30px;background:red;width:364px;margin-top:5px;margin-left:261px;font-size:0px;">', '</div>');
							?>
						</div>
						<div class="col-sm-22">
							<?php
								echo form_submit('submit', 'Submit','style="width:100px;" class="btn btn-success" onclick="return confirm(\'Are you sure want to Add New Details? \')"'); 
							?>
						</div>
					</div>
					<div class="wrapp">
						<table class="table table-secondary">
							<tr>
							  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:230%;">Product</td>
							  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Stock</td>
							  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Buy</td>
							  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Sale</td>
							  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">General</td>
							</tr>
							<tr>
								<td style="width:230%;">  <?php echo $product_name?></td>
								<td >  <?php echo $available_stock ?></td>				
								<td >  <?php echo $buy_price ?></td>			
								<td >  <?php echo $sale_price ?></td>		
								<td >  <?php echo $general_sale_price ?></td>	
							</tr> 
						</table>
					</div>
				</div>
			</div>
		</div>	
	</div>	
</section>
	<?php
	} 
	?>
<section>
	<div class="row">
		<div class="col-md-12">
			<div class="box" style="margin-bottom:4px;">
				<div class="box-body">
					<table class="table table-secondary">
						<tr>
						  <td colspan="1" style="text-align:left;text-indent:5px;font-size:15px;width:35px;color:#444;font-weight:bold;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"> Delete</td>
						  <td colspan="2" style="text-align:left;text-indent:5px;font-size:15px;width:35px;color:#444;font-weight:bold;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"><a href="<?php echo base_url();?>product/delete_all_barcode_print_product" class="btn-primary" title="Delete All" id="print" style="text-decoration:none;"><i class="fa fa-fw fa-close"></i> Delete All</a></td>
						  <td colspan="1" style="text-align:left;text-indent:5px;font-size:15px;width:35px;color:#444;font-weight:bold;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"> Print</td>
						  <td colspan="2" style="text-align:left;text-indent:5px;font-size:15px;width:35px;color:#444;font-weight:bold;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"><a href="<?php echo base_url();?>product/print_barcode_by_search" target="_blank" class="btn-primary" id="print" style="text-decoration:none;"><i class="fa fa-print"></i> Print</a></td>
						</tr>
						<tr>
						  <td>S/N</td>
						  <td width="60%">Product Name</td>
						  <td>Quantity</td>
						  <td>Sale Price</td>
						  <td>Action</td>
						</tr>
							<?php
								if($listed_product->num_rows() > 0){
									$i=1;
								foreach($listed_product->result() as $field){
							?>
							<tr>
									<td >  <?php echo $i;?></td>
									<td style="width:350%;"> <?php echo $field->product_name;?></td>
									<td >  <?php echo $field->quantity?></td>				
									<td >  <?php echo $field-> sale_price ?></td>
									<td >  <a href="<?php echo base_url();?>product/delete_barcode_print_product/<?php echo $field->print_id;?>" class="edit_link" title="delete"><i class="fa fa-fw fa-close"></i></a>
									</td>
							</tr> 
								<?php 
								$i++;
								}
								}
								else{ ?>
									<tr><td colspan="6"><h3 class="text-center"> No Product Availavle for Print</h3></td></tr>
								<?php 
								}
								?>
						</table>
				</div>
			</div>
		</div>
	</div>	
</section>
</div>