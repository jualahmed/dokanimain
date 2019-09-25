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
			<table class="table" style="margin-top:20px;">
				<thead>
					<tr>
						<td colspan="3" style="text-align:center;">Date Duration</td>
					</tr>
				</thead>	
				<tbody>	
					<tr>
						<td colspan="3" style="text-align:center;"> <?php echo $this->uri->segment(3) .'- -'. $this->uri->segment(4); ?>  </td>
					</tr>
				</tbody>
			</table>
			<table class="table">
				<thead>
					<tr class="tableRowBG">
					  <td colspan="3" style="text-align:center;">Cash In Hand</td>
					  <td colspan="3" style="text-align:center;">Cash In Bank</td>
					</tr>
				</thead>	
				<tbody>	
					<tr>
						<td colspan="3" style="text-align:center;"> <?php echo sprintf('%0.2f',$transaction8); ?>  </td>
						<td colspan="3" style="text-align:center;"> <?php echo sprintf('%0.2f',$transaction9); ?>  </td>
					</tr>
				</tbody>
			</table>
		<?php
			foreach($transaction_sum as $field_sum):
			$transaction_purposes=$field_sum['transaction_purpose'];
			endforeach;
		?>
		<div style="background: #bbbfc1;">
			<center><h3>Sale</h3></center>
		</div>
		<table class="table table-bordered">
			<thead>
				<tr class="tableRowBG">
				  <td colspan="3">SL No</td>
				  <td colspan="3">Date</td>
				  <td colspan="3">Ledger Name</td>
				  <td colspan="3">Particular</td>
				  <td colspan="3">Remarks</td>
				  <td colspan="3" style="text-align:right;">Amount</td>
				</tr>
			</thead>	
			<tbody>	
			<?php
			$in =1;
			$total_sale =0.00;
			foreach($transaction2 as $field2):
			?>
				<tr>
					<td colspan="3"> <?php echo $in; ?>  </td>
					<td colspan="3"> <?php echo $field2['date']; ?>  </td>
					<td colspan="3"> <?php echo $field2['customer_name']; ?>  </td>
					<td colspan="3"> <?php echo $field2['transaction_purpose']; ?>  </td>
					<td colspan="3"> <?php echo $field2['remarks']; ?>  </td>
					<td colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$field2['amount']); ?> </td>
					<?php $total_sale += $field2['amount'];?>
				</tr>
			<?php
				$in++;
				endforeach;
				
			?>
				<tr>
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3">Total</td>
					<td colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$total_sale); ?> </td>
				</tr>
			</tbody>
		</table>
		<div class="box-header with-border" style="background: #bbbfc1;">
			<center><h3 class="box-title" style="text-align:center;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-weight:noraml;">Collection</h3></center>
		</div>
		<table class="table">
			<thead>
				<tr class="tableRowBG">
				  <td colspan="3">SL No</td>
				  <td colspan="3">Date</td>
				  <td colspan="3">Ledger Name</td>
				  <td colspan="3">Particular</td>
				  <td colspan="3">Remarks</td>
				  <td colspan="3" style="text-align:right;">Amount</td>
				</tr>
			</thead>	
			<tbody>	
			<?php
			$in2 =1;
			$total_collection =0.00;
			foreach($transaction as $field):
			?>
				<tr>
					<td colspan="3"> <?php echo $in2; ?>  </td>
					<td colspan="3"> <?php echo $field['date']; ?>  </td>
					<td colspan="3"> <?php echo $field['customer_name']; ?>  </td>
					<td colspan="3"> <?php echo $field['transaction_purpose']; ?>  </td>
					<td colspan="3"> <?php echo $field['remarks']; ?>  </td>
					<td colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$field['amount']); ?> </td>
					<?php $total_collection += $field['amount'];?>
				</tr>
			<?php
				$in2++;
				endforeach;
				
			?>
				<tr class="tableRowBG">
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3">Total</td>
					<td colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$total_collection); ?> </td>
				</tr>
			</tbody>
		</table>
		<div class="box-header with-border" style="background: #bbbfc1;">
			<center><h3 class="box-title" style="text-align:center;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-weight:noraml;">Credit Collection</h3></center>
		</div>
		<table class="table">
			<thead>
				<tr class="tableRowBG">
				  <td colspan="3">SL No</td>
				  <td colspan="3">Date</td>
				  <td colspan="3">Ledger Name</td>
				  <td colspan="3">Particular</td>
				  <td colspan="3">Remarks</td>
				  <td colspan="3" style="text-align:right;">Amount</td>
				</tr>
			</thead>	
			<tbody>	
			<?php
			$in3 =1;
			$total_credit_collection =0.00;
			if(isset($transaction3))foreach($transaction3 as $field3):
			?>
				<tr>
					<td colspan="3"> <?php echo $in3; ?>  </td>
					<td colspan="3"> <?php echo $field3['date']; ?>  </td>
					<td colspan="3"> <?php echo $field3['customer_name']; ?>  </td>
					<td colspan="3"> <?php echo $field3['transaction_purpose']; ?>  </td>
					<td colspan="3"> <?php echo $field3['remarks']; ?>  </td>
					<td colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$field3['amount']); ?> </td>
					<?php $total_credit_collection += $field3['amount'];?>
				</tr>
			<?php
				$in3++;
				endforeach;
				
			?>
				<tr class="tableRowBG">
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3">Total</td>
					<td colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$total_credit_collection); ?> </td>
				</tr>
			</tbody>
		</table>
		<div class="box-header with-border" style="background: #bbbfc1;">
			<center><h3 class="box-title" style="text-align:center;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-weight:noraml;">Purchase</h3></center>
		</div>
		<table class="table">
			<thead>
				<tr class="tableRowBG">
				  <td colspan="3">SL No</td>
				  <td colspan="3">Date</td>
				  <td colspan="3">Ledger Name</td>
				  <td colspan="3">Particular</td>
				  <td colspan="3">Remarks</td>
				  <td colspan="3" style="text-align:right;">Amount</td>
				</tr>
			</thead>	
			<tbody>	
			<?php
			$in4 =1;
			$total_purchase =0.00;
			foreach($transaction4 as $field4):
			?>
				<tr>
					<td colspan="3"> <?php echo $in4; ?>  </td>
					<td colspan="3"> <?php echo $field4['date']; ?>  </td>
					<td colspan="3"> <?php echo $field4['distributor_name']; ?>  </td>
					<td colspan="3"> <?php echo $field4['transaction_purpose']; ?>  </td>
					<td colspan="3"> <?php echo $field4['remarks']; ?>  </td>
					<td colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$field4['amount']); ?> </td>
					<?php $total_purchase += $field4['amount'];?>
				</tr>
			<?php
				$in4++;
				endforeach;
				
			?>
				<tr class="tableRowBG">
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3">Total</td>
					<td colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$total_purchase); ?> </td>
				</tr>
			</tbody>
		</table>
		<div class="box-header with-border" style="background: #bbbfc1;">
			<center><h3 class="box-title" style="text-align:center;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-weight:noraml;">Purchase Payment</h3></center>
		</div>
		<table class="table">
			<thead>
				<tr class="tableRowBG">
				  <td colspan="3">SL No</td>
				  <td colspan="3">Date</td>
				  <td colspan="3">Ledger Name</td>
				  <td colspan="3">Particular</td>
				  <td colspan="3">Remarks</td>
				  <td colspan="3" style="text-align:right;">Amount</td>
				</tr>
			</thead>	
			<tbody>	
			<?php
			$in5 =1;
			$total_purchase_payment =0.00;
			foreach($transaction5 as $field5):
			?>
				<tr>
					<td colspan="3"> <?php echo $in5; ?>  </td>
					<td colspan="3"> <?php echo $field5['date']; ?>  </td>
					<td colspan="3"> <?php echo $field5['distributor_name']; ?>  </td>
					<td colspan="3"> <?php echo $field5['transaction_purpose']; ?>  </td>
					<td colspan="3"> <?php echo $field5['remarks']; ?>  </td>
					<td colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$field5['amount']); ?> </td>
					<?php $total_purchase_payment += $field5['amount'];?>
				</tr>
			<?php
				$in5++;
				endforeach;
				
			?>
				<tr class="tableRowBG">
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3">Total</td>
					<td colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$total_purchase_payment); ?> </td>
				</tr>
			</tbody>
		</table>
		<div class="box-header with-border" style="background: #bbbfc1;">
			<center><h3 class="box-title" style="text-align:center;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-weight:noraml;">Expense</h3></center>
		</div>
		<table class="table">
			<thead>
				<tr class="tableRowBG">
				  <td colspan="3">SL No</td>
				  <td colspan="3">Date</td>
				  <td colspan="3">Ledger Name</td>
				  <td colspan="3">Particular</td>
				  <td colspan="3">Remarks</td>
				  <td colspan="3" style="text-align:right;">Amount</td>
				</tr>
			</thead>	
			<tbody>	
			<?php
			$in6 =1;
			$total_expense =0.00;
			if(isset($transaction6))foreach($transaction6 as $field6):
			?>
				<tr>
					<td colspan="3"> <?php echo $in6; ?>  </td>
					<td colspan="3"> <?php echo $field6['date']; ?>  </td>
					<td colspan="3"> <?php echo $field6['type_type']; ?>  </td>
					<td colspan="3"> <?php echo $field6['expense_details']; ?>  </td>
					<td colspan="3"> <?php echo $field6['remarks']; ?>  </td>
					<td colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$field6['amount']); ?> </td>
					<?php $total_expense += $field6['amount'];?>
				</tr>
			<?php
				$in6++;
				endforeach;
				
			?>
				<tr class="tableRowBG">
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3">Total</td>
					<td colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$total_expense); ?> </td>
				</tr>
			</tbody>
		</table>
		<div class="box-header with-border" style="background: #bbbfc1;">
			<center><h3 class="box-title" style="text-align:center;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-weight:noraml;">Expense Payment</h3></center>
		</div>
		<table class="table">
			<thead>
				<tr class="tableRowBG">
				  <td colspan="3">SL No</td>
				  <td colspan="3">Date</td>
				  <td colspan="3">Ledger Name</td>
				  <td colspan="3">Particular</td>
				  <td colspan="3">Remarks</td>
				  <td colspan="3" style="text-align:right;">Amount</td>
				</tr>
			</thead>	
			<tbody>	
			<?php
			$in7 =1;
			$total_expense_payment =0.00;
			if(isset($transaction7))foreach($transaction7 as $field7):
			?>
				<tr>
					<td colspan="3"> <?php echo $in7; ?>  </td>
					<td colspan="3"> <?php echo $field7['date']; ?>  </td>
					<td colspan="3"> <?php echo $field7['type_type']; ?>  </td>
					<td colspan="3"> <?php echo $field7['expense_details']; ?>  </td>
					<td colspan="3"> <?php echo $field7['remarks']; ?>  </td>
					<td colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$field7['amount']); ?> </td>
					<?php $total_expense_payment += $field7['amount'];?>
				</tr>
			<?php
				$in7++;
				endforeach;
				
			?>
				<tr class="tableRowBG">
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
					<td colspan="3">Total</td>
					<td colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$total_expense_payment); ?> </td>
				</tr>
			</tbody>
		</table>
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


