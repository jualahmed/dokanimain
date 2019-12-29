<div class="content-wrapper">
	<section class="content">
	  <div class="row">
		<div class="col-md-12">
		  <div class="box">
			<div class="box-body">
			  <div class="col-md-3">
				<div class="info-box">
				  <span class="info-box-text bg-aqua" style="text-align:center;"><!--img style="color:white; height:50px; width:50px;" src="<?php echo base_url();?>assets2/512/ios7-cart.png"--> Total Sale
					<span class="info-box-number" style="text-align:center;">
					  <?php
						echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round($sale_price_info, 2);
						if($sale_price_info == round($sale_price_info, 0))
						  echo'.00';
						else if(round($sale_price_info, 1) == round($sale_price_info, 2))
						  echo'.00';
						echo nbs(2); 
					  ?>
					</span>
				  </span>
				</div>
			  </div>
			  <div class="col-md-3">
				<div class="info-box">
				  <span class="info-box-text bg-green" style="text-align:center;"><!--img style="color:white; height:50px; width:50px;" src="<?php echo base_url();?>assets2/512/ios7-cart.png"--> Total Due
					<span class="info-box-number" style="text-align:center;">
					  <input type="hidden" value="<?php echo $due1 = $grand_price_info - $total_price_info; ?>" >
					  <input type="hidden" value="<?php echo $due2 = $grand_price_info; ?>" >
					  <input type="hidden" value="<?php echo $due22 = $grand_price_info - $due1; ?>" >
					  <input type="hidden" value="<?php echo $due3 = $total_price_info; ?>" >
					  <input type="hidden" value="<?php echo $due4 = $main_cash_info; ?>" >
					  <input type="hidden" value="<?php echo $due5 = $main_cash_out_info; ?>" >
					  <?php
						$due = $sale_price_info - $main_cash_info;
						echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round($due, 2);
						if($due == round($due, 0))
						  echo'.00';
						else if(round($due, 1) == round($due, 2))
						  echo'.0';
						echo nbs(2); 
					  ?>
					</span>
				  </span>
				</div>
			  </div>

			  <div class="col-md-3">
				<div class="info-box">
				  <span class="info-box-text bg-yellow" style="text-align:center;"><!--img style="color:white; height:50px; width:50px;" src="<?php echo base_url();?>assets2/512/model-s.png"--> Purchase
					<span class="info-box-number" style="text-align:center;">
					  <?php
						echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round($purchase_info, 2);
						if($purchase_info == round($purchase_info, 0))
						  echo'.00';
						else if(round($purchase_info, 1) == round($purchase_info, 2))
						  echo'.00';
						echo nbs(2); 
					  ?>
					</span>
				  </span>
				</div>
			  </div>
			  <div class="col-md-3">
				<div class="info-box">
				  <span class="info-box-text bg-red disabled color-palette" style="text-align:center;"><!--img style="color:white; height:50px; width:50px;" src="<?php echo base_url();?>assets2/512/ios7-calculator.png"--> Expense
					<span class="info-box-number" style="text-align:center;">
					  <?php
						echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round($expense_info, 2);
						if($expense_info == round($expense_info, 0))
						  echo'.00';
						else if(round($expense_info, 1) == round($expense_info, 2))
						  echo'.00';
						echo nbs(2);
					  ?>
					</span>
				  </span>
				</div>
			  </div>
			  <div class="col-md-3">
				<div class="info-box">
				  <span class="info-box-text bg-primary" style="text-align:center;"><!--img style="color:white; height:50px; width:50px;" src="<?php echo base_url();?>assets2/512/card.png"--> Credit Colletion
					<span class="info-box-number" style="text-align:center;">
					  <?php
						$csh = $main_credit_receive_info;
						echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round($csh, 2);
						if($csh == round($csh, 0))
						  echo'.00';
						else if(round($csh, 1) == round($csh, 2))
						  echo'.0';
						echo nbs(2); 
						echo '</br>';
					  ?>
					</span>
				  </span>
				</div>
			  </div>
			  <div class="col-md-3">
				<div class="info-box">
				  <span class="info-box-text bg-teal" style="text-align:center;"><!--img style="color:white; height:50px; width:50px;" src="<?php echo base_url();?>assets2/512/social-usd.png"--> Cash in Hand
					<span class="info-box-number" style="text-align:center;">
					  <input type="hidden" value="<?php echo $due1 = $grand_price_info - $total_price_info; ?>" >
					  <input type="hidden" value="<?php echo $due2 = $grand_price_info; ?>" >
					  <input type="hidden" value="<?php echo $due22 = $grand_price_info - $due1; ?>" >
					  <input type="hidden" value="<?php echo $expense_info = $expense_info; ?>" >
					  <?php
						$csh1 = $grand_price_info - $total_price_info;
						$csh2 = $grand_price_info - $due1;
						$csh3 = $csh2;
						$csh = $main_cash_info;
						 echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round($csh, 2);
						if($csh == round($csh, 0))
						  echo'.00';
						else if(round($csh, 1) == round($csh, 2))
						  echo'.0';
						echo nbs(2); 
						echo '</br>';
					  ?>
					</span>
				  </span>
				</div>
			  </div>
			  <!--div class="col-md-2">
				<div class="info-box">
				  <span class="info-box-text bg-light-blue-active color-palette" style="text-align:center;"><img style="color:white; height:50px; width:50px;" src="<?php echo base_url();?>assets2/512/bank.png"> Cash Bank </span>
				  <span class="info-box-number" style="text-align:center;">
					<?php
					  $csh = $main_card_receive_info;
					  echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round($csh, 2);
					  if($csh == round($csh, 0))
						echo'.00';
					  else if(round($csh, 1) == round($csh, 2))
						echo'.0';
					  echo nbs(2); 
					  echo '</br>';
					?>
				  </span>
				</div>
			  </div-->
			  <div class="col-md-3">
				<div class="info-box">
				  <span class="info-box-text bg-maroon color-palette" style="text-align:center;"><!--img style="color:white; height:50px; width:50px;" src="<?php echo base_url();?>assets2/512/clipboard.png"--> Stock
					<span class="info-box-number" style="text-align:center;">
					  <?php echo '&#2547; '.round($total_stock_price);?>
					</span>
				  </span>
				</div>
			  </div>
			  <div class="col-md-3">
				<div class="info-box">
				  <span class="info-box-text bg-purple disabled color-palette" style="text-align:center;"><!--img style="color:white; height:50px; width:50px;" src="<?php echo base_url();?>assets2/512/filing.png"--> Quantity
					<span class="info-box-number" style="text-align:center;">
					  <?php echo round($total_stock_quantity);?> P
					</span>
				  </span>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	</section>
 
  </div>