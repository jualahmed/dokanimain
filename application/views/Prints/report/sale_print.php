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
								<th>Product</th>
								<th>Model</th>
								<th>Company</th>
								<th>Catagory</th>
								<th>Customer Name</th>
								<th>Mobile No</th>
								<th>Quantity</th>
								<th>BP</th>
								<th>SP</th>
								<th style="text-align: right;">Profit</th> 
								<th>Seller</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$qty=0;
							$amount=0;
							$samount=0; 
							foreach ($data as $key => $var): $qty=$qty+$var->sale_quantity; $amount=$amount+($var->unit_buy_price*$var->sale_quantity); $samount=$samount+($var->actual_sale_price*$var->sale_quantity); ?>
							<tr>
								<td><?php echo $key+1 ?></td>
								<td align="center"><?php echo $var->sid ?></td>
								<td></td>
								<td><?php echo $var->product_name ?></td>
								<td><?php echo $var->product_model ?></td>
								<td><?php echo $var->company_name ?></td>
								<td><?php echo $var->catagory_name ?></td>
								<td><?php echo $var->customer_name ?></td>
								<th ><?php echo $var->customer_contact_no ?></th>
								<th style="text-align: center;"><?php echo number_format($var->sale_quantity, 2) ?></th>
								<td style="text-align: right;"><?php echo number_format($var->unit_buy_price, 2); ?></td>
								<th style="text-align: right;"><?php echo number_format($var->actual_sale_price, 2); ?></th>
								<th style="text-align: right;"><?php echo number_format($var->actual_sale_price - $var->unit_buy_price, 2); ?></th>
								<td><?php echo $var->username ?></td>
							</tr>
							<?php endforeach ?>
							<tr>
								<td colspan="9">Total</td>
								<td style="text-align: center;"><b><?php echo number_format($qty, 2) ?></b></td>
								<td style="text-align: center;"><b><?php echo number_format($amount, 2) ?></b></td>
								<td style="text-align: center;"><b><?php echo number_format($samount, 2) ?></b></td>
								<td style="text-align: center;"><b><?php echo number_format($samount - $amount, 2) ?></b></td>
								<td></td>
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