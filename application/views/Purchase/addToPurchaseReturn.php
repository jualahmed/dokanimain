<tr>
	<td><?php echo $purchase_return_distributor_info; ?></td>
	<td><?php echo $product_name; ?></td>
	<td style="text-align: center;"><?php echo $qnty; ?></td>
	<td style="text-align: right;"><?php echo $unit_buy_price; ?></td>
	<td style="text-align: right;" class="total_sale_price_final" ><?php echo $qnty * $unit_buy_price; ?></td>
	<td id="<?php echo $id; ?>" name="dlt_btn" style="text-align: center; color: red;"> <i class="fa fa-fw fa-remove renove_btn"></i> </td>
</tr>