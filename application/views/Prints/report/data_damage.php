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
			<?php if ($download_data_damage->num_rows()>0): ?>
				<table class="table table-bordered">
					<tr>
					  <td>No</td>
					  <td>Date</td>
					  <td>Product</td>
					  <td title="Purchase Quantity">Quantity</td>
					  <td>BP</td>
					</tr>
					<?php foreach ($download_data_damage->result() as $key => $var):?>
						<tr>
						  <td><?php echo $key ?></td>
						  <td><?php echo $var->doc; ?></td>
						  <td><?php echo $var->product_name ?></td>
						  <td title="Purchase Quantity"><?php echo $var->damage_quantity ?></td>
						  <td><?php echo $var->unit_buy_price ?></td>
						</tr>
					<?php endforeach ?>
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
