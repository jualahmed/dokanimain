<tr>
	<td><?php echo $product_name; ?></td>
	<td style="text-align: center;"><?php echo $qnty; ?></td>
	<td style="text-align: right;"><?php echo sprintf('%0.2f',$unit_price); ?></td>
	<td style="text-align: right;" class="total_sale_price_final" ><?php echo sprintf('%0.2f',$qnty * $unit_price); ?></td>
	<td id="<?php echo $id; ?>" name="dlt_btn" style="text-align: center; color: red;"> <i class="fa fa-fw fa-remove remove_btn"></i> </td>
</tr>