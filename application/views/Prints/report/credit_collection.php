
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
			<?php if ($all_credit_collection->num_rows()>0): ?>
				<table class="table table-bordered">
					<tr>
					  <td>No</td>
					  <td>Mode</td>
					  <td>Customer ID</td>
					  <td>Customer Name</td>
					  <td>Amount</td>
					  <td>Date</td>
					  <td>Creator</td>
					</tr>
					<?php $stockqty=0;$samount=0;foreach ($all_credit_collection->result() as $key => $var): $samount=$samount+$var->amount ?>
						<tr>
						  <td><?php echo $key ?></td>
						  <td><?php echo $var->transaction_mode; ?></td>
						  <td title="Receipt ID"><?php echo $var->ledger_id ?></td>
						  <td><?php echo $var->customer_name ?></td>
						  <td><?php echo $var->amount ?></td>
						  <td><?php echo $var->date ?></td>
						  <td title="Purchase Quantity"><?php echo $var->user_full_name ?></td>
						</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="4"><b></b></td>
						<td colspan="1"><b>Total: <?php echo $samount ?></b> </td>
						<td colspan="2"><b></b></td>
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
