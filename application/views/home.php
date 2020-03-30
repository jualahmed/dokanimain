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
						echo number_format((float)$sale_price_info, 2, '.', '');
					  ?>
					</span>
				  </span>
				</div>
			  </div>
			  <div class="col-md-3">
				<div class="info-box">
				  <span class="info-box-text bg-green" style="text-align:center;">Total Due
					<span class="info-box-number" style="text-align:center;">
					  <?php
						$due = $sale_price_info - $main_cash_info-$main_credit_receive_info;
						echo number_format((float)$due, 2, '.', '');
					  ?>
					</span>
				  </span>
				</div>
			  </div>

			  <div class="col-md-3">
				<div class="info-box">
				  <span class="info-box-text bg-yellow" style="text-align:center;"> Purchase
					<span class="info-box-number" style="text-align:center;">
					<?php
						echo number_format((float)$purchase_info, 2, '.', '');
					?>
					</span>
				  </span>
				</div>
			  </div>
			  <div class="col-md-3">
				<div class="info-box">
				  <span class="info-box-text bg-primary" style="text-align:center;">Credit Colletion
					<span class="info-box-number" style="text-align:center;">
					  <?php
						echo number_format((float)$main_credit_receive_info, 2, '.', '');
					  ?>
					</span>
				  </span>
				</div>
			  </div>
			
			  <div class="col-md-3">
				<div class="info-box">
				  <span class="info-box-text bg-maroon color-palette" style="text-align:center;">
				  	Stock
					<span class="info-box-number" style="text-align:center;">
					  <?php echo number_format((float)$total_stock_price, 2, '.', ''); ?>
					</span>
				  </span>
				</div>
			  </div>
			  <div class="col-md-3">
				<div class="info-box">
				  <span class="info-box-text bg-purple disabled color-palette" style="text-align:center;">Quantity
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