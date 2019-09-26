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
					<?php foreach ($purchase_data->result() as $key => $var): ?>
						<tr>
						  <td><?php echo $key ?></td>
						  <td><?php echo $var->purchase_date; ?></td>
						  <td title="Receipt ID"><?php echo $var->receipt_id ?></td>
						  <td><?php echo $var->company_name ?></td>
						  <td><?php echo $var->catagory_name ?></td>
						  <td><?php echo $var->product_name ?></td>
						  <td title="Purchase Quantity">1</td>
						  <td><?php echo $var->bulk_unit_buy_price ?></td>
						</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="6"><b></b></td>
						<td colspan="1"><b>Total Quantity: {{ stockqty }}</b> </td>
						<td colspan="1"><b>Total Stock Amount: {{ samount }}</b></td>
					</tr>
				</table>
			</div>
			<h2 class="text-danger text-center">Result Empty</h2>
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
