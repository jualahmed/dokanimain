<?php
$purchase = 0;
$sale = 0;
$opening_stock = 0;
$closing_stock = 0;
$cash_in_hand = 0;
$cash_in_bank = 0;
$gross_profit = 0;
foreach ($allstatment as $key => $value) : ?>
	<?php
	$purchase = $purchase + $value->purchase;
	$sale = $sale + $value->sale;
	$opening_stock = $opening_stock + $value->stock_opening;
	$closing_stock = $closing_stock + $value->stock_current;
	$cash_in_hand = $cash_in_hand + $value->stock_current;
	$cash_in_bank = $cash_in_bank + $value->cash_in_bank;
	$gross_profit = $gross_profit + $value->gross_profit;
	?>
<?php endforeach ?>

<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Financial Statement Search</h3>
					</div>
					<div class="box-body">
						<form action="<?php echo base_url(); ?>Report/financial_statement" method="post" enctype="multipart/form-data" id="form_3" class="form-horizontal" autocomplete="off">
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-1 control-label">Single</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text', 'placeholder' => $bd_date, 'name' => "specific_date", 'class' => "form-control", 'id' => "datep", 'tabindex' => 3, 'title' => "Start Date")); ?>
								</div>
								<label for="inputPassword3" class="col-sm-1 control-label">Duration</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text', 'placeholder' => $bd_date, 'name' => "start_date", 'class' => "form-control", 'id' => "datepickerrr", 'tabindex' => 3, 'title' => "Start Date")); ?>
								</div>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text', 'placeholder' => $bd_date, 'name' => "end_date", 'class' => "form-control", 'id' => "datepickerr", 'tabindex' => 3, 'title' => "End Date")); ?>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-body">
						<div class="wrap-1">
							<div class="table-responsive">
								<table class="teble w-100">
									<tr>
										<td colspan="1">S.Date</td>
										<th colspan="2"><?php echo date("d-m-Y", strtotime($start_date)) . nbs(5); ?></th>
										<td colspan="1">E.Date</td>
										<th colspan="2"><?php echo date("d-m-Y", strtotime($end_date)); ?></th>
									</tr>
								</table>
							</div>
						</div>
						<br>
						<div>
							<table class="table table-bordered">
								<tr>
									<th>Purchase</th>
									<th style="text-align: right;">&#2547; <?php
																			echo number_format($purchase, 2, '.', '');
																			?></th>
								</tr>
								<tr>
									<th>Opening Stock</th>
									<td style="text-align: right;">&#2547;
										<?php
										echo number_format($opening_stock, 2, '.', '');
										?>
									</td>
								</tr>
								<tr>
									<th>(-) Closing Stock.</th>
									<td style="text-align: right;">&#2547;
										<?php
										echo number_format($closing_stock, 2, '.', '');
										?>
									</td>
								</tr>
								<tr>
									<th>Cash in hand</th>
									<td style="text-align: right;">&#2547;
										<?php
										echo number_format($cash_in_hand, 2, '.', '');
										?>
									</td>
								</tr>
								<tr>
									<th>Cash in bank</th>
									<td style="text-align: right;">&#2547;
										<?php
										echo number_format($cash_in_bank, 2, '.', '');
										?>
									</td>
								</tr>
								<tr>
									<th>Profit</th>
									<td style="text-align: right;">&#2547;
										<?php
										echo number_format($gross_profit, 2, '.', '');
										?>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>