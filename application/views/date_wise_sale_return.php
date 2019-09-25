<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="mid_box_top">
		<p> Date Wise Sale Return </p>
		<?php
			if($action == 'modify') 
				echo form_open('modify/sale_modify');
			else echo form_open('Report/sale_return_report');
			echo form_submit('submit', 'Back', 'style="float:right;height:30px;margin:1px 2px 1px 0px"');
			echo form_close();
		?>
	</div>
	<div class="CSSTableGenerator" style="">
		<table >
			<tr>
				<td> No </td>
				<td > invoice ID</td>
				<td >Customer Name </td>
				<td > Total  ( Tk ) </td>
				<td > Return Product</td>
				<td > Return Quantity</td>
				<td > Return Amount</td>
				<td > Date  </td>
				<td >Creator</td>
				<td>
					<?php
						if($action == 'modify')echo 'Modify';
						else echo 'Details';
					?>
				</td>
			</tr>
		
			<?php
				$index = 1;
				$total_sale = 0;
				$total_receivable = 0;
				$total_quantity = 0;
				$total_return_amount = 0;
				foreach($all_invoice_id -> result() as $field):
			?>
			<tr>
				<td> <?php echo $index; ?> </td>
				<td> <?php echo $field -> invoice_id; ?> </td> 
				
		        <td style="text-align:left"> <?php echo $field -> customer_name; ?>  </td>
		        <td style = "text-align:right;">
					<?php 
					echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round($field -> grand_total, 2);
						$total_sale += $field -> grand_total;
						
						$total_quantity += $field -> return_quantity;
						
						$total_return_amount += $field -> return_amount;
		        	?> 
		        </td>
				<td style = " text-align:right;">
					<?php 
						echo $field -> product_name;
					?> 
				</td>
		        <td style = " text-align:right;">
					<?php 
						echo $field -> return_quantity;
						
						$total_receivable += ($field -> grand_total - $field -> total_paid);
					?> 
				</td>
				<td style = " text-align:right;">
					<?php 
						echo $field -> return_amount;
					?> 
				</td>
				<td> <?php echo $field -> DOC; ?> </td> 
				<td> <?php echo $field -> username; ?> </td> 
		        <td>
					 <?php
							if($action == 'modify')
								echo anchor('modify/generate_invoice_details/'.$field -> invoice_id, img('images/megnify_2.png') ,'class = "table_img" target="_blank"');
							else echo anchor('expenseinvoice/generate_invoice/'.'old_invoice/'.$field -> invoice_id, img('images/megnify_2.png') ,'class = "table_img" target="_blank"');
					?>
				</td>
		    </tr>
			<?php
				$index++;
				endforeach;
			?>
			<tr>
				<td >  </td>
				<td >  </td>
				<td  colspan=2>  </td> 
				<td  colspan=2>
					Total Return:
					<?php echo $total_quantity; ?>
				
				</td>
				<td colspan=2>
					Total Return Amount:
					<?php echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round( $total_return_amount, 2); ?>
				
				</td>
				<td colspan=2>

				</td>
			</tr>
		</table>		
	</div> <!--End of CSSTableGenerator DIV-->
