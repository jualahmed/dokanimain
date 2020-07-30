<!DOCTYPE HTML>
<html>
<head>
	<title> Dokani : IT Lab Solutions </title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
	<style>
		body {
			font-size: 12px !important;
		}
	</style>
</head>
<?php 
	$this->load->config('custom_config'); 
	$pre_blance_show_invoice = $this->config->item('pre_blance_show_invoice');
?>
<body> 
 	<div id ="main_invoice" style="width: 700px;padding:15px;">
		<div id = "invoice" style="text-align: center;">
			<div id = "shop_title_test"> <?php echo $this->tank_auth->get_shopname(); ?>  </div>
			<div id = "shop_address_test">  <?php echo $this->tank_auth->get_shopaddress(); ?></div>	
			<div id = "shop_address_test"> Contact: <?php echo $this->tank_auth->get_shopcontact(); ?> </div>
			<?php
				$shop_id=$this->tank_auth->get_shop_id();
				$this->db->where('shop_id',$shop_id);
				$shop_info=$this->db->get('shop_setup')->row();
			?>
			<?php if ($shop_info->invoicelogo): ?>
				<img style="width: 100%;" src="<?php echo base_url();?>assets/img/shop/<?php echo $shop_info->invoicelogo ?>">
			<?php else: ?>
				<img style="width: 50%;height: 100px" src="<?php echo base_url();?>assets/img/top_logo2.png">
			<?php endif ?> 
		</div>
        
		<?php
		if($this->uri->segment(3)=='payable')
		{
		?>
		<div class="row">
			
			<table class="table table-bordered" style="margin-top:15px;">
				<thead>
					<tr>
						<th>Distributor Name</th>
						<th>Distributor Contact</th>
						<th>Distributor Address</th>
						<th>Total Amount</th>
						<th>Paid Amount</th>
						<th>Return Amount</th>
						<th style="text-align:right;">Due Amount</th>
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
								<th><?php echo $distributor_name; ?></th>
								<td><?php echo $distributor_contact_no; ?></td>
								<td><?php echo $distributor_address; ?></td>
								<th style="text-align:right;"><?php echo sprintf('%0.2f',$purchase_amount+$balance_amount_all); ?></th>
								<th style="text-align:right;"><?php echo sprintf('%0.2f',$total_payment_amount); ?></th>
								<th style="text-align:right;"><?php echo sprintf('%0.2f',$payment_delete_amount_all + $return_amount_all); ?></th>
								<th style="text-align:right;"><?php echo sprintf('%0.2f',$purchase_amount+$balance_amount_all-$total_payment_amount-$payment_delete_amount_all-$return_amount_all); ?>  </th>
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
			
			<table class="table table-bordered" style="margin-top:20px;">
				<tr>
					<th style="text-align:left;">Total</th>
					<th style="text-align:right;"> <?php echo sprintf('%0.2f',$total_payable); ?>  </th>
				</tr>
			</table>
		</div>
		<?php
		}
		else if($this->uri->segment(3)=='receive')
		{
		
		?>
		<div class="row">
			
			<table class="table table-bordered" style="margin-top:15px;">
				<thead>
					<tr class="tableRowBG">
						<th>Customer Name</th>
						<th>Customer Contact</th>
						<th>Customer Address</th>
						<th>Total Amount</th>
						<th>Receive Amount</th>
						<th>Return Amount</th>
						<th style="text-align:right;">Due Amount</th>
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
									<th><?php echo $customer_name; ?></th>
									<td><?php echo $customer_contact_no; ?></td>
									<td><?php echo $customer_address; ?></td>
									<th style="text-align:right;"><?php echo sprintf('%0.2f',$sale_amount+$balance_amount_all); ?></th>
									<th style="text-align:right;"><?php echo sprintf('%0.2f',$total_collection_amount); ?></th>
									<th style="text-align:right;"><?php echo sprintf('%0.2f',$total_sale_return_amount); ?></th>
									
									<th style="text-align:right;"><?php echo sprintf('%0.2f',$sale_amount+$total_sale_return_amount+$balance_amount_all-$total_collection_amount-$total_sale_return_amount); ?>  </th>
									
								</tr>
								
								<?php
								$total_receivable+=$sale_amount+$total_sale_return_amount+$balance_amount_all-$total_collection_amount-$total_sale_return_amount;
								}
								else
								{
								?>
								<tr>
									<th><?php echo $customer_name; ?></th>
									<td><?php echo $customer_contact_no; ?></td>
									<td><?php echo $customer_address; ?></td>
									<th style="text-align:right;"><?php echo sprintf('%0.2f',$sale_amount+$balance_amount_all); ?></th>
									<th style="text-align:right;"><?php echo sprintf('%0.2f',$total_collection_amount); ?></th>
									<th style="text-align:right;"><?php echo sprintf('%0.2f',$total_sale_return_amount); ?></th>
									
									<th style="text-align:right;"><?php echo sprintf('%0.2f',$sale_amount+$balance_amount_all-$total_collection_amount-$total_sale_return_amount); ?>  </th>
									
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
			
			<table class="table table-bordered" style="margin-top:20px;">
				<tr>
					<th style="text-align:left;">Total</th>
					<th style="text-align:right;"> <?php echo sprintf('%0.2f',$total_receivable); ?>  </th>
				</tr>
			</table>
		</div>
		<?php
		}
		else if($this->uri->segment(3)=='expense_payable')
		{
		?>
		<div class="row">
			
			<table class="table table-bordered" style="margin-top:15px;">
				<thead>
					<tr class="tableRowBG">
						<th>Type Name</th>
						<th>Total Amount</th>
						<th>Payment Amount</th>
						<th>Return Amount</th>
						<th style="text-align:right;">Due Amount</th>
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
								<th><?php echo $type_name; ?></th>
								<th style="text-align:right;"><?php echo sprintf('%0.2f',$total_expense_amount); ?></th>
								<th style="text-align:right;"><?php echo sprintf('%0.2f',$total_expense_payment_amount); ?></th>
								<th style="text-align:right;"><?php echo sprintf('%0.2f',$total_delete_expense_amount); ?></th>
								<th style="text-align:right;"><?php echo sprintf('%0.2f',$total_expense_amount-$total_expense_payment_amount+$total_delete_expense_amount); ?>  </th>
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
			
			<table class="table table-bordered" style="margin-top:20px;">
				<tr>
					<th style="text-align:left;">Total</th>
					<th style="text-align:right;"> <?php echo sprintf('%0.2f',$total_expense_payable); ?>  </th>
				</tr>
			</table>
		</div>
		<?php
		}
		?>
	</div>
</body>
</html>	
