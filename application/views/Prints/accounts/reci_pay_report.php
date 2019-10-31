<table style="width: 100%;">
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
      <div class="page text-center" style="line-height: 3;">
		<?php
				if($this->uri->segment(3)=='payable')
				{
				?>
				<div class="row">
					<table class="table" style="margin-top:15px;">
						<thead>
							<tr class="tableRowBG">
								<th colspan="3">Distributor Name</th>
								<th colspan="3">Distributor Contact</th>
								<th colspan="3">Distributor Address</th>
								<th colspan="3">Total Amount</th>
								<th colspan="3">Paid Amount</th>
								<th colspan="3">Return Amount</th>
								<th colspan="3" style="text-align:right;">Due Amount</th>
							</tr>
						</thead>	
						<tbody>	
							<?php
								$total_payable=0.00;
								foreach($payable as $temp)
								{
									$i=1;
									foreach($temp['receipt_purchase_total_amount'] as $field_purchase_total)
									{
										$purchase_amount= $field_purchase_total['total_purchase_amount']; 
										$distributor_name = $field_purchase_total['distributor_name']; 
										$distributor_contact_no = $field_purchase_total['distributor_contact_no']; 
										$distributor_address = $field_purchase_total['distributor_address']; 
									
										foreach($temp['receipt_payment_total_amount'] as $field_payment_total)
										{
											$total_payment_amount= $field_payment_total['total_payment_amount']; 
										}
										foreach($temp['receipt_payment_delete_total_amount'] as $field_payment_delete_total)
										{
											$payment_delete_amount_all= $field_payment_delete_total['total_delete_payment_amount']; 
										}
										foreach($temp['receipt_purchase_return_total_amount'] as $field_return_total)
										{
											$return_amount_all= $field_return_total['total_purchase_return_amount']; 
										}
										foreach($temp['receipt_balance_total_amount'] as $field_balance_total_amount)
										{
											$balance_amount_all= $field_balance_total_amount['total_balance_amount']; 
										}
							?>
									<tr>
										<th colspan="3"><?php echo $distributor_name; ?></th>
										<th colspan="3"><?php echo $distributor_contact_no; ?></th>
										<th colspan="3"><?php echo $distributor_address; ?></th>
										<th colspan="3" style="text-align:right;"><?php echo sprintf('%0.2f',$purchase_amount+$balance_amount_all); ?></th>
										<th colspan="3" style="text-align:right;"><?php echo sprintf('%0.2f',$total_payment_amount); ?></th>
										<th colspan="3" style="text-align:right;"><?php echo sprintf('%0.2f',$payment_delete_amount_all + $return_amount_all); ?></th>
										<th colspan="3" style="text-align:right;"><?php echo sprintf('%0.2f',$purchase_amount+$balance_amount_all-$total_payment_amount-$payment_delete_amount_all-$return_amount_all); ?>  </th>
									</tr>
							<?php
									$total_payable+=$purchase_amount+$balance_amount_all-$total_payment_amount-$payment_delete_amount_all-$return_amount_all;
									}
									
								}
							?>
						</tbody>
					</table>
				</div>
				<div class="row">
					<table class="table" style="margin-top:20px;">
						<thead>
							<tr class="tableRowBG">
								<th colspan="3" style="text-align:center;">Total</th>
							</tr>
						</thead>	
						<tbody>
							<tr>
								<th colspan="3" style="text-align:center;"> <?php echo sprintf('%0.2f',$total_payable); ?>  </th>
							</tr>
						</tbody>
					</table>
				</div>
				<?php
				}
				else if($this->uri->segment(3)=='receive')
				{
				?>
				<div class="row">
					<table class="table" style="margin-top:15px;">
						<thead>
							<tr class="tableRowBG">
								<th colspan="3">Customer Name</th>
								<th colspan="3">Customer Contact</th>
								<th colspan="3">Customer Address</th>
								<th colspan="3">Total Amount</th>
								<th colspan="3">Receive Amount</th>
								<th colspan="3">Return Amount</th>
								<th colspan="3" style="text-align:right;">Due Amount</th>
							</tr>
						</thead>	
						<tbody>	
							<?php
								$total_receivable=0;
								foreach($receive as $temp2)
								{
									$i=1;
									
									foreach($temp2['receipt_sale_total_amount'] as $field_sale_total)
									{
										$sale_amount = $field_sale_total['total_sale_amount']; 
										$customer_id = $field_sale_total['customer_id']; 
										$customer_name = $field_sale_total['customer_name']; 
										$customer_contact_no = $field_sale_total['customer_contact_no']; 
										$customer_address = $field_sale_total['customer_address']; 
									
										foreach($temp2['receipt_collection_total_amount'] as $field_collection_total)
										{
											$total_collection_amount = $field_collection_total['total_collection_amount']; 
										}
										foreach($temp2['receipt_sale_return_total_amount'] as $field_sale_return_total)
										{
											$total_sale_return_amount = $field_sale_return_total['total_sale_return_amount']; 
										}
										foreach($temp2['receipt_balance_total_amount'] as $field_balance_total_amount)
										{
											$balance_amount_all = $field_balance_total_amount['total_balance_amount']; 
										}
							?>
										<?php
										if($customer_id==1)
										{
										?>
										<tr>
											<th colspan="3"><?php echo $customer_name; ?></th>
											<th colspan="3"><?php echo $customer_contact_no; ?></th>
											<th colspan="3"><?php echo $customer_address; ?></th>
											<th colspan="3" style="text-align:right;"><?php echo sprintf('%0.2f',$sale_amount+$balance_amount_all); ?></th>
											<th colspan="3" style="text-align:right;"><?php echo sprintf('%0.2f',$total_collection_amount); ?></th>
											<th colspan="3" style="text-align:right;"><?php echo sprintf('%0.2f',$total_sale_return_amount); ?></th>
											
											<th colspan="3" style="text-align:right;"><?php echo sprintf('%0.2f',$sale_amount+$total_sale_return_amount+$balance_amount_all-$total_collection_amount-$total_sale_return_amount); ?>  </th>
											
										</tr>
										
										<?php
										$total_receivable+=$sale_amount+$total_sale_return_amount+$balance_amount_all-$total_collection_amount-$total_sale_return_amount;
										}
										else
										{
										?>
										<tr>
											<th colspan="3"><?php echo $customer_name; ?></th>
											<th colspan="3"><?php echo $customer_contact_no; ?></th>
											<th colspan="3"><?php echo $customer_address; ?></th>
											<th colspan="3" style="text-align:right;"><?php echo sprintf('%0.2f',$sale_amount+$balance_amount_all); ?></th>
											<th colspan="3" style="text-align:right;"><?php echo sprintf('%0.2f',$total_collection_amount); ?></th>
											<th colspan="3" style="text-align:right;"><?php echo sprintf('%0.2f',$total_sale_return_amount); ?></th>
											
											<th colspan="3" style="text-align:right;"><?php echo sprintf('%0.2f',$sale_amount+$balance_amount_all-$total_collection_amount-$total_sale_return_amount); ?>  </th>
											
										</tr>
										
										<?php
										$total_receivable+=$sale_amount+$balance_amount_all-$total_collection_amount-$total_sale_return_amount;
										}
										?>
							<?php
									}
								}
							?>
						</tbody>
					</table>
				</div>
				<div class="row">
					<table class="table" style="margin-top:20px;">
						<thead>
							<tr class="tableRowBG">
								<th colspan="3" style="text-align:center;">Total</th>
							</tr>
						</thead>	
						<tbody>
							<tr>
								<th colspan="3" style="text-align:center;"> <?php echo sprintf('%0.2f',$total_receivable); ?>  </th>
							</tr>
							
						</tbody>
					</table>
				</div>
				<?php
				}
				else if($this->uri->segment(3)=='expense_payable')
				{
				?>
				<div class="row">
					
					<table class="table" style="margin-top:15px;">
						<thead>
							<tr class="tableRowBG">
								<th colspan="3">Type Name</th>
								<th colspan="3">Total Amount</th>
								<th colspan="3">Payment Amount</th>
								<th colspan="3">Return Amount</th>
								<th colspan="3" style="text-align:right;">Due Amount</th>
							</tr>
						</thead>	
						<tbody>	
							<?php
								$total_expense_payable=0;
								foreach($expense_payable as $temp3)
								{
									$i=1;
									
									foreach($temp3['receipt_expense_total_amount'] as $field_expense_total)
									{
										$total_expense_amount = $field_expense_total['total_expense_amount']; 
										$type_name = $field_expense_total['type_type']; 
									
										foreach($temp3['receipt_expense_payment_total_amount'] as $field_expense_payment_total)
										{
											$total_expense_payment_amount = $field_expense_payment_total['total_expense_payment_amount']; 
										}
										foreach($temp3['receipt_expense_delete_total_amount'] as $field_expense_delete_amount)
										{
											$total_delete_expense_amount = $field_expense_delete_amount['total_delete_expense_amount']; 
										}
							?>
									<tr>
										<th colspan="3"><?php echo $type_name; ?></th>
										<th colspan="3" style="text-align:right;"><?php echo sprintf('%0.2f',$total_expense_amount); ?></th>
										<th colspan="3" style="text-align:right;"><?php echo sprintf('%0.2f',$total_expense_payment_amount); ?></th>
										<th colspan="3" style="text-align:right;"><?php echo sprintf('%0.2f',$total_delete_expense_amount); ?></th>
										<th colspan="3" style="text-align:right;"><?php echo sprintf('%0.2f',$total_expense_amount-$total_expense_payment_amount+$total_delete_expense_amount); ?>  </th>
									</tr>
							<?php
									$total_expense_payable+=$total_expense_amount-$total_expense_payment_amount+$total_delete_expense_amount;
									}
								}
							?>
						</tbody>
					</table>
					
				</div>
				
				<div class="row">
					
					<table class="table" style="margin-top:20px;">
						<thead>
							<tr class="tableRowBG">
								<th colspan="3" style="text-align:center;">Total</th>
							</tr>
						</thead>	
						<tbody>
							<tr>
								<th colspan="3" style="text-align:center;"> <?php echo sprintf('%0.2f',$total_expense_payable); ?>  </th>
							</tr>
							
						</tbody>
					</table>
				</div>
				<?php
				}
				?>
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
