<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Comission Entry</h3>
					</div>
					<form action="<?php echo base_url();?>comission/create" method="post" id="comission" class="form-horizontal">
						<div class="box-body">
							<div class="form-group">
							<?php
									$now=Date("Y");
									$old=$now-100;
									for($i=$now;$i>=$old;$i--)
									{
										if($i==$now)
											$year['']='Select Year';		
										$year[$now]=$now;
										$now--;
									}
								?>
								<label for="inputEmail3" class="col-sm-3 control-label">Month <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<select class="select2 form-control" id="com_month" name="com_month" tabindex="-1" style="width:100%;">
										<option value="">Select Month</option>
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">August</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">Novermber</option>
										<option value="12">December</option>
									</select>
								</div>
							</div>
							<br>	
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Amount  <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input type="text" name="com_amount" value="" class="form-control" id="com_amount" placeholder="In Taka /=" autocomplete="off">
								</div>
							</div>
							<div class="box-footer text-right">
								<div class="col-sm-22">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-12">
				<table class="table table-secondary">
					<tr>
						<th>Month</th>
						<th>Amount</th>
					</tr>
					<?php foreach ($all as $value) { ?>
						<tr>
							<td><?php echo $value->com_month ?></td>
							<td><?php echo $value->com_amount ?></td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</section>		
</div>
