<table style="width: 100%">
  <thead>
    <tr>
      <td>
        <div class="page-header-space"></div>
      </td>
    </tr>
  </thead>

  <tbody>
    <tr>
      <td>
        <div class="page">
			<div class="table-responsive">
			<?php if ($purchase_data->num_rows()>0): ?>
				<table class="table table-bordered">
					<tr>
					  <td>No</td>
					  <td>Date</td>
					  <td title="Receipt ID">R.ID</td>
					  <td>Company</td>
					  <td>Category</td>
					  <td>Product</td>
					  <td title="Purchase Quantity">Quantity</td>
					  <td>BP</td>
					</tr>
					<?php $stockqty=0;$samount=0;foreach ($purchase_data->result() as $key => $var): $stockqty=$stockqty+$var->purchase_quantity;$samount=$samount+($var->unit_buy_price*$var->purchase_quantity) ?>
						<tr>
						  <td><?php echo $key ?></td>
						  <td><?php echo $var->receipt_date; ?></td>
						  <td title="Receipt ID"><?php echo $var->receipt_id ?></td>
						  <td><?php echo $var->company_name ?></td>
						  <td><?php echo $var->catagory_name ?></td>
						  <td><?php echo $var->product_name ?></td>
						  <td title="Purchase Quantity"><?php echo $var->purchase_quantity ?></td>
						  <td><?php echo $var->unit_buy_price ?></td>
						</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="6"><b></b></td>
						<td colspan="1"><b>Total Quantity: <?php echo $stockqty ?></b> </td>
						<td colspan="1"><b>Total Purchase Amount: <?php echo $samount ?></b></td>
					</tr>
				</table>
			</div>
			<?php else: ?>
				<h2 class="text-danger text-center">Result Empty</h2>
			<?php endif ?>
        </div>
      </td>
    </tr>
  </tbody>

  <tfoot>
    <tr>
      <td>
        <div class="page-footer-space"></div>
      </td>
    </tr>
  </tfoot>
</table>
