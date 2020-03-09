<div class="content-wrapper">
	<section>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Ledger</h3>
					</div>
					<div class="box-body">
						<input type="hidden" id="action" >
						<form class="form-horizontal" id="form_2" method="post" action="<?php echo base_url();?>account/all_ledger_report_find">
							<div class="col-md-3">
								<div class="form-group">
									<label for="inputEmail3" class="control-label">Customer</label>
									<select name="customer_id" id="" class="form-control">
										<option value="">Customer Name</option>
										<?php foreach ($customer as $key => $var): ?>
											<option value="<?php echo $var->customer_id ?>"><?php echo $var->customer_name ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="inputEmail3" class="control-label">Start Date</label>
									<div>
										<?php 
											echo form_input('start', '','class ="form-control" id="start" placeholder="Start Date" autocomplete="off"');
										?>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div>
									<label for="inputEmail3" class="control-label">End Date</label>
									<div>
										<?php 
											echo form_input('end', '','class ="form-control" id="end" placeholder="End Date" autocomplete="off"');
										?>
									</div>
								</div>
							</div>
							<div class="form-group text-right">
								<div class="col-sm-12">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" id="form_submit"><i class="fa fa-fw fa-search"></i> Search</button>
									<a href="<?php echo base_url();?>account/all_ledger_report_print" id="down" style="display:none;" target="_blank" class="btn btn-primary btn-sm down"><i class="fa fa-download"></i> Print</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<div class="modal_loader preload" style="display: none">
		<div class="center">
			<img src="<?php echo base_url();?>assets/img/LoaderIcon.gif" id="loaderIcon"/>
		</div>
	</div>
	<?php $camount=0;$amount=0; ?>
	<section class="content infomsg" id="infomsg">
		<div class="row">
			<?php if(isset($debit)){ ?>
				<div class="col-md-6">
					<div class="box">	 
						<div class="box-body">
							<div class="box-header with-border">
								<h3 class="box-title">Total Sale</h3>
							</div>
							<div class="wrap">
								<table class="table">
									<tr>
										<td>Date</td>
										<td>Details</td>
										<td>Total Amount</td>
										<td>Balance</td>
									</tr>
									<?php $camount=0; foreach ($debit as $key => $var): ?> <?php $camount+=$var->amount ?>
										<tr>
											<td><?php echo $var->date ?></td>
											<td><?php echo $var->remarks ?></td>
											<td><?php echo $var->amount ?></td>
											<td><?php echo $camount ?></td>
										</tr>
									<?php endforeach ?>
									
									<tr>
										<td></td>
										<td>Total:</td>
										<td><?php echo $camount ?></td>
										<td><?php echo $camount ?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if(isset($credit)){ ?>
				<div class="col-md-6">
					<div class="box">	 
						<div class="box-body">
							<div class="box-header with-border">
								<h3 class="box-title">Collection Total</h3>
							</div>
							<div class="wrap">
								<table class="table">
									<tr>
										<td>Date</td>
										<td>Details</td>
										<td>Total Amount</td>
										<td>Balance</td>
									</tr>
									<?php if(isset($credit)){ $amount=0; foreach ($credit as $key => $var): ?> <?php $amount+=$var->amount ?>
										<tr>
											<td><?php echo $var->date ?></td>
											<td><?php echo $var->remarks ?></td>
											<td><?php echo $var->amount ?></td>
											<td><?php echo $amount ?></td>
										</tr>
									<?php endforeach ?>
									<?php } ?>
									<tr>
										<td></td>
										<td>Total:</td>
										<td><?php echo $amount ?></td>
										<td><?php echo $amount ?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<h2 class="text-center">Total Due: <?php echo $camount-$amount ?> BDT</h2>	
	</section>

</div>
