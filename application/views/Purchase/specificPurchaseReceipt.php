
<?php foreach($receipt_general_details->result() as $tmp){?>
<tr>
    <td style="width: 25%;vertical-align:middle;background-color:#ecf0f5;">Distributor Name</td>
    <td colspan="3" style="vertical-align:middle;background-color:#ecf0f5;">
		<?php echo $tmp->distributor_name; }?>
	</td>
</tr>
<tr>
	<td style="vertical-align:middle;background-color:#ecf0f5;"> Receipt ID </td>
	<td style="width: 25%;vertical-align:middle;background-color:#ecf0f5;">
		<?php echo $tmp->receipt_id; ?> 
	</td>
	<td style="width: 25%;vertical-align:middle;background-color:#ecf0f5;">
		Purchase Date 
	</td>
	<td style="vertical-align:middle;background-color:#ecf0f5;">
		<?php echo $tmp->receipt_date;	?> 
	</td>
</tr>
<tr>
	<td style="vertical-align:middle;background-color:#ecf0f5;">Purchase Price</td>
	<td style="text-align: right;vertical-align:middle;background-color:#ecf0f5;">
		<?php echo $tmp->purchase_amount; ?> 
	</td>
	<td style="vertical-align:middle;background-color:#ecf0f5;">Discount</td>
	<td style="text-align: right;vertical-align:middle;background-color:#ecf0f5;">
		<?php echo $tmp->gift_on_purchase; ?> 
	</td>
</tr>
<tr>
	<td style="vertical-align:middle;background-color:#ecf0f5;">Grand Total</td>
	<td style="text-align: right;vertical-align:middle;background-color:#ecf0f5;">
	<?php echo $tmp->grand_total; ?> 
	</td>
	<td style="vertical-align:middle;background-color:#ecf0f5;">Transport Cost</td>
	<td style="text-align: right;vertical-align:middle;background-color:#ecf0f5;">
	<?php echo $tmp->transport_cost; ?> 
	</td>
</tr>