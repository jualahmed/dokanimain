<table style="width: 100%">
	<thead>
	  <tr>
	    <td>
	      <!--place holder for the fixed-position header-->
	      <div class="page-header-space"></div>
	    </td>
	  </tr>
	</thead>

	<tbody>
	  <tr>
	    <td>
	      <div class="page">
	       	<section class="content" style="padding: 0px;">
	       		<?php if (count($data)>0): ?>
					<table class="table table-bordered">
						<thead class="table">
							<tr>
								<th>NO</th>
								<th>Invoice ID</th>
								<th>Date</th>
								<th>Product Model</th>
								<th>Company</th>
								<th>Catagory</th>
								<th>Customer Name</th>
								<th>Mobile No</th>
								<th>Quantity</th>
								<th>BP</th>
								<th>SP</th>
								<th>Seller</th>
							</tr>
						</thead>
						<tbody>
							<?php $qty=0;$amount=0;$samount=0; foreach ($data as $key => $var): $qty=$qty+$var->sale_quantity; $amount=$amount+($var->unit_buy_price*$var->sale_quantity); $samount=$samount+($var->actual_sale_price*$var->sale_quantity); ?>
							<tr>
								<td><?php echo $key+1 ?></td>
								<td align="center"><?php echo $var->sid ?></td>
								<td></td>
								<td><?php echo $var->product_name ?></td>
								<td><?php echo $var->company_name ?></td>
								<td><?php echo $var->catagory_name ?></td>
								<td><?php echo $var->customer_name ?></td>
								<th ><?php echo $var->customer_contact_no ?></th>
								<th ><?php echo $var->sale_quantity ?></th>
								<td><?php echo $var->unit_buy_price ?></td>
								<th ><?php echo $var->actual_sale_price ?></th>
								<td><?php echo $var->username ?></td>
							</tr>
							<?php endforeach ?>
							<tr>
								<td colspan="8"></td>
								<td><b>Total BP: <?php echo $qty ?></b></td>
								<td><b>Total BP: <?php echo $amount ?></b></td>
								<td><b>Total SP: <?php echo $samount ?></b></td>
							</tr>
						</tbody>
					</table>
	       		<?php else: ?>
				<div>
					<h2 class="text-danger text-center">Result is Empty</h2>
				</div>
				<?php endif ?>
			</section>
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