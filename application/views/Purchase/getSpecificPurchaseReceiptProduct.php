
<?php 
	$i = 1;
	$total_amount = 0;
	foreach($purchase_receipt_details->result() as $tmp)
	{ 
?>
		<tr>
			<td style="width: 4%; "><?php echo $i;?></td>
			<td style="width: 6%; "><?php echo $tmp->product_id;?></td>
			<td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap; width: 35%;" title="<?php echo $tmp->product_name;?>"><?php echo $tmp->product_name;?></td>
			<td style="text-align: center;width: 6%;"><?php echo $tmp->number_of_quantity;?></td>
			<td style="text-align: right;width: 10%;"><?php echo round($tmp->unit_buy_price, 2);?></td>
			<td style="text-align: right;width: 10%;" class="total_purchase_price_final"><?php echo round($tmp->unit_buy_price * $tmp->number_of_quantity, 2);?></td>
			<td style="text-align: center;width: 6%;">
				<input type="hidden" value="<?php echo $tmp->product_specification;?>" id="spec<?php echo $tmp->product_id;?>">
				<i class="fa fa-fw fa-edit css_for_cursor" style="color: #db8b0b; " id='<?php echo $tmp->product_id;?>' name="edit"	title="Edit"></i>
				<?php 
					if($tmp->product_specification==1)
					{
				?>
				<i class="fa fa-fw fa-remove css_for_cursor" style="color: red; " id='<?php echo $tmp->product_id;?>' name="remove" title="Remove"></i>
				<?php 
					}
				?>
			</td>
		</tr>

<?php
	$i++;
	}
?>
<script>
$(document).ready(function()
{
	var total_final = 0.00;
	$('.total_purchase_price_final').each(function(){
		total_final += parseFloat($(this).text()); 
	});
	$('#total_purchase_price_new_final').html(total_final.toFixed(2));
});
</script>