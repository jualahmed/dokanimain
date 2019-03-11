<tr>
	<td><?php echo $product_id; ?></td>
	<td><?php echo $product_name; ?></td>
	<td style="text-align: center;"><?php echo $quantity; ?></td>
	<td style="text-align: right;"><?php echo $unit_buy_price; ?></td>
	<td style="text-align: right;" class="total_purchase_price_final"><?php echo $total_buy_price; ?></td>
	<!-- <td style="text-align: center; color: #db8b0b;"></td> -->
	<td style="text-align: center;">
		<i class="fa fa-fw fa-edit css_for_cursor"   id="<?php echo $product_id; ?>" 	name="edit" 	style="color: #db8b0b;" title="Edit"></i>
		<i class="fa fa-fw fa-remove css_for_cursor" id="<?php echo $product_id; ?>"	name="remove" 	style=" color: red;" title="Remove"></i>
	</td>
</tr>