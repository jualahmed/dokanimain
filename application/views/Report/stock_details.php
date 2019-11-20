<div class="content-wrapper" id="vueapp">
	<br>
	<div class="box-header with-border">
		<h3 class="box-title">Motorcycle Stock Details Report</h3>
		<h3 class="box-title text-right"> <a href="<?php echo base_url() ?>Report/stock_details_print" id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration: none;"><i class="fa fa-download"></i> Download</a></h3>
	</div>
	<div class="table-responsive">
		<table class="table table-secondary">
		<tr>
		    <th>No</th>
		    <th>Company</th>
		    <th>Category</th>
		    <th>Product</th>
		    <th>Serial No</th>
		    <th title="Purchase Quantity">Quantity</th>
		    <th>BP</th>
		    <th>SP</th>
		</tr>
		<?php $i=0;$amount=0;$samount=0; foreach ($reportdata as $key => $var): $i++;$amount=$amount+$var->general_unit_sale_price;$samount=$samount+$var->bulk_unit_buy_price ?>
			<tr>
				<td><?php echo $i ?></td>
			    <td><?php echo $var->company_name ?></td>
			    <td><?php echo $var->catagory_name ?></td>
			    <td><?php echo $var->product_name ?></td>
			    <td><?php echo $var->sl_no ?></td>
			    <td title="Purchase Quantity">1</td>
			    <td><?php echo $var->bulk_unit_buy_price ?></td>
			    <td><?php echo $var->general_unit_sale_price ?></td>
			</tr>
		<?php endforeach ?>
			<tr>
				<td colspan="5"><b></b></td>
				<td colspan="1"><b>Total Quantity: <?php echo $i ?></b></td>
				<td colspan="1"><b>Total Amount: <?php echo $samount ?></b></td>
				<td colspan="1"><b>Total Sale Amount: <?php echo $amount ?></b></td>
			</tr>
	</table>
	</div>
</div>
