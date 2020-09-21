

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
					<?php if(count($temp->result())>0){ ?>
						<table class="table table-bordered">
							<tr>
								<th>No.</th>
								<th width="18%">Product</th>
								<th>Category</th>
								<th>Company</th>
								<th>Product Size</th>
								<th>Product Model</th>
								<th align="center">Stock.</th>
								<th align="right">Buy Price</th>
								<th align="right">Total BP</th>
								<th align="right">Sale Price</th>
								<th align="right">Total SP</th>
							</tr>
							<?php $stockqty=0;$amount=0;$samount=0; foreach ($temp->result() as $key => $var):$stockqty=$stockqty+$var->stock_amount;$amount=$amount+($var->stock_amount*$var->bulk_unit_buy_price) ;$samount=$samount+($var->stock_amount*$var->general_unit_sale_price)?>
								<tr v-for="(d,index) in alldata">
									<td><?php echo $key+1 ?></td> 
									<td width="18%"><?php echo $var->product_name ?></td>
									<td><?php echo $var->catagory_name ?></td>
									<td><?php echo $var->company_name ?></td>
									<td><?php echo $var->product_size ?></td>
									<td><?php echo $var->product_model ?></td>
									<td class="text-center"><?php echo $var->stock_amount ?></td>
									<td class="text-right"><?php echo sprintf("%01.2f", $var->bulk_unit_buy_price) ?></td>
									<td class="text-right"><?php echo sprintf("%01.2f", $var->bulk_unit_buy_price * $var->stock_amount) ?></td>
									<td class="text-right"><?php echo sprintf("%01.2f", $var->general_unit_sale_price) ?></td>
									<td class="text-right"><?php echo sprintf("%01.2f", $var->general_unit_sale_price * $var->stock_amount) ?></td>
								</tr>
							<?php endforeach ?>
							<tr>
								<td colspan="6"><b>Total</b></td>
								<td class="text-right"><b><?php echo $stockqty ?></b> </td>
								<td></td>
								<td class="text-right"><b><?php echo sprintf("%01.2f", $amount) ?></b></td>
								<td></td>
								<td class="text-right"><b><?php echo sprintf("%01.2f", $samount) ?></b></td>
							</tr>
						</table>
						<?php } else{?>
						<h2 class="text-danger text-center">Result is Empty</h2>
						<?php } ?>
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