<div class="content-wrapper" id="vueapp">

	<div class="box-header with-border table-bordered">
		<h3 class="box-title">Motorcycle Stock Details Report</h3>
	</div>
	<table class="table table-secondary">
		<tr>
		    <th>No</th>
		    <th>Company</th>
		    <th>Category</th>
		    <th>Product</th>
		    <th>SL NO</th>
		    <th title="Purchase Quantity">Quantity</th>
		    <th>BP</th>
		    <th>SP</th>
		</tr>
		<?php $i=0;$amount=0; foreach ($reportdata as $key => $var): $i++;$amount=$amount+$var->general_unit_sale_price; ?>
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
				<td colspan="6"><b>Total Amount: <?php echo $amount ?></b></td>
			</tr>
	</table>
</div>
