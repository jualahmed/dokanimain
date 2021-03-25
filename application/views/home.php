<div class="content-wrapper">
	<section class="content">
	  	<div class="row">
			<div class="col-md-12">
			  <div class="box">
				<div class="box-body">
				<div class="col-md-3">
				  	<div class="small-box bg-green">
						<div class="inner">
							<h3><?php
								echo $invoice_info;
							?></h3>

							<p>Invoice</p>
						</div>
						<div class="icon">
							<i class="fa fa-file-o"></i>
						</div>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				  </div>

				  <div class="col-md-3">
				  	<div class="small-box bg-blue">
						<div class="inner">
							<h3><?php
								echo number_format((float)$sale_price_info, 2, '.', '');
							?></h3>

							<p>Today's Sale</p>
						</div>
						<div class="icon">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				  </div>
				  <div class="col-md-3">
				  	<div class="small-box bg-aqua">
						<div class="inner">
						<h3>
						<?php
							echo number_format((float)$due_price_info, 2, '.', '');
						?>
						</h3>

						<p>Today's Due</p>
						</div>
						<div class="icon">
						<i class="fa fa-money"></i>
						</div>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				  </div>

				  <div class="col-md-3">
				  	<div class="small-box bg-orange">
						<div class="inner">
							<h3>
							<?php
								echo number_format((float)$today_credit_receive_info, 2, '.', '');
							?>
							</h3>

							<p>Today's Credit Collection</p>
						</div>
						<div class="icon">
							<i class="fa fa-money"></i>
						</div>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				  </div>


				  <div class="col-md-3">
				  	<div class="small-box bg-aqua">
						<div class="inner">
							<div class="icon">
								<i class="fa fa-money"></i>
							</div>
							<h3>
							<?php
								echo number_format((float)$purchase_info, 2, '.', '');
							?>
							</h3>

							<p>Today's Purchase</p>
						</div>
						
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				  </div>


				  <div class="col-md-3">
				  	<div class="small-box bg-orange">
						<div class="inner">
							<h3><?php
								echo $running_sale;
							?></h3>

							<p>Running Sale</p>
						</div>
						<div class="icon">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				  </div>

				  <div class="col-md-3">
				  	<div class="small-box bg-green">
						<div class="inner">
							<h3>
							<?php
								echo number_format((float)$main_credit_receive_info, 2, '.', '');
							?>
							</h3>

							<p>Total Credit Collection</p>
						</div>
						<div class="icon">
							<i class="fa fa-money"></i>
						</div>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				  </div>

				  

				  <div class="col-md-3">
				  	<div class="small-box bg-primary">
						<div class="inner">
						<h3>
						<?php echo round($total_stock_quantity);?>
						</h3>

						<p>Total Stock Quantity</p>
						</div>
						<div class="icon">
						<i class="fa fa-sort-amount-desc"></i>
						</div>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				  </div>
				
				  <div class="col-md-3">
				  	<div class="small-box bg-green">
						<div class="inner">
						<h3>
						<?php echo number_format((float)$total_stock_price, 2, '.', ''); ?>
						</h3>

						<p>Total Stock Price</p>
						</div>
						<div class="icon">
						<i class="fa fa-money"></i>
						</div>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<?php if ($statment->count()==0): ?>
					<a href="<?php echo base_url().'admin/dailystatement' ?>" class="btn btn-success">Update Financial Statement</a>
				<?php endif ?>
				<a href="<?php echo base_url().'admin/download_database' ?>" class="btn btn-info">Database Backup</a>
			</div>
		</div>
	</section>
</div>