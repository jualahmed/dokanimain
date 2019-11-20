<div class="content-wrapper">
<?php
	$purchase_total_amount = 0;
	foreach($payable_receivable_financial_statement['updated_purchase'] -> result() as $field):	
		 $temp_payable_1 = $field->unpaid_grand_total-$field->total_paid_amount;
		 $purchase_total_amount = $field->total_purchase_amount;
	endforeach;
?>
	<section class="content">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">SCB Search</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>Report/scb_report" method="post" enctype="multipart/form-data" id="form_3" class="form-horizontal" autocomplete="off">
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-2 control-label">Duration</label>
								<div class="col-sm-3">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr", 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<div class="col-sm-3">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a href="<?php echo base_url();?>Report/download_scb_report/<?php echo $this->uri->segment(3);?>/<?php echo $this->uri->segment(4);?>" target="_blank" class="btn btn-primary btn-sm" style="text-decoration:none;"><i class="fa fa-download"></i> Down</a>
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
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Stock Report</h3>
			  <h5>
			  
			  <?php
				$start_date = $this->uri->segment(3);
				$end_date = $this->uri->segment(4);
				if(($start_date!=''&& $end_date=='null'))
				{
					$start_date = $start_date;
					$end_date = $start_date;
				}
				else if($start_date=='' && $end_date=='')
				{
					$start_date = $bd_date;
					$end_date = $bd_date;
				}
				else
				{
					$start_date = $start_date;
					$end_date = $end_date;
				}
			  ?>
			  Date Range : <?php echo $start_date.'--'.$end_date;?>
			  </h5>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tbody><tr>
                  <th>Title</th>
                  <th style="text-align:right;">Amount</th>
                </tr>
                <tr>
                  <td>Opening Stock (+)</td>
                 
                </tr>
				<tr>
                  <td>Purchase (+)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$purchase_total_amount);?></td>
                </tr>
				<tr>
                  <td>Purchase Return (-)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$purchase_return_info);?></td>
                </tr>
				<tr>
                  <td>Sale (-)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$sale_price_info);?></td>
                </tr>
				<tr>
                  <td>Sale Return (+)</td>
                </tr>
				<tr>
                  <td>Closing Stock</td>
                 
                </tr>
              </tbody>
			  </table>
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Cash Book</h3>
			  <h5>
			  
			  <?php
				$start_date = $this->uri->segment(3);
				$end_date = $this->uri->segment(4);
				if(($start_date!=''&& $end_date=='null'))
				{
					$start_date = $start_date;
					$end_date = $start_date;
				}
				else if($start_date=='' && $end_date=='')
				{
					$start_date = $bd_date;
					$end_date = $bd_date;
				}
				else
				{
					$start_date = $start_date;
					$end_date = $end_date;
				}
			  ?>
			  Date Range : <?php echo $start_date.'--'.$end_date;?>
			  </h5>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tbody><tr>
                  <th>Title</th>
                  <th style="text-align:right;">Amount</th>
                </tr>
                <tr>
                  <td>Opening Balance (+)</td>
                  <td style="text-align:right;">
					<?php 
						$in = $from_bank_opening+$from_owner_opening+$cash_sale_opening+$cash_delivery_charge_opening+$cash_credit_collection_opening;
						$out = $to_bank_opening+$to_owner_opening+$cash_sale_return_opening+$cash_purchase_payment_opening+$cash_expense_payment_opening;
						$opening_balance = $in-$out;
						echo sprintf('%0.2f',$opening_balance);
					?>
				  </td>
                </tr>
				<tr>
                  <td>From Bank (+)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$from_bank);?></td>
                </tr>
				<tr>
                  <td>To Bank (-)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$to_bank);?></td>
                </tr>
				<tr>
                  <td>From Owner (+)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$from_owner);?></td>
                </tr>
				<tr>
                  <td>To Owner (-)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$to_owner);?></td>
                </tr>

				<tr>
                  <td>Cash Sale (+)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$cash_sale);?></td>
                </tr>
				<tr>
                  <td>Delivery Charge (+)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$cash_delivery_charge);?></td>
                </tr>
				<tr>
                  <td>Due Collection (+)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$cash_credit_collection);?></td>
                </tr>
				<tr>
                  <td>Cash Sale Return (-)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$cash_sale_return);?></td>
                </tr>
				<tr>
                  <td>Purchase Payment (-)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$cash_purchase_payment);?></td>
                </tr>
				<tr>
                  <td>Purchase Cash Return (+)</td>
                  <td style="text-align:right;">0.00</td>
                </tr>
				<tr>
                  <td>Expense Payment (-)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$cash_expense_payment);?></td>
                </tr>
				<tr>
                  <td>Cash in Hand</td>
                  <td style="text-align:right;">
					<?php 
						$in = $opening_balance+$from_bank+$from_owner+$cash_sale+$cash_delivery_charge+$cash_credit_collection;
						$out = $to_bank+$to_owner+$cash_sale_return+$cash_purchase_payment+$cash_expense_payment;
						
						echo sprintf('%0.2f',$in-$out);
					?>
				  
				  </td>
                </tr>
              </tbody>
			  </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
		<div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Bank Book</h3>
			  <h5>
			  
			  <?php
				$start_date = $this->uri->segment(3);
				$end_date = $this->uri->segment(4);
				if(($start_date!=''&& $end_date=='null'))
				{
					$start_date = $start_date;
					$end_date = $start_date;
				}
				else if($start_date=='' && $end_date=='')
				{
					$start_date = $bd_date;
					$end_date = $bd_date;
				}
				else
				{
					$start_date = $start_date;
					$end_date = $end_date;
				}
			  ?>
			  Date Range : <?php echo $start_date.'--'.$end_date;?>
			  </h5>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tbody><tr>
                  <th>Title</th>
                  <th>Amount</th>
                </tr>
                <tr>
                  <td>Opening Balance (+)</td>
                  <td style="text-align:right;">
					<?php 
						$in = $to_bank_opening+$from_owner_bank_opening+$card_sale_opening+$card_delivery_charge_opening+$bank_credit_collection_opening;
						
						$out = $from_bank_opening+$to_owner_bank_opening+$bank_sale_return_opening+$bank_purchase_payment_opening+$bank_expense_payment_opening;
						$opening_balance = $in-$out;
						echo sprintf('%0.2f',$opening_balance);
					?>
				  </td>
                </tr>
				<tr>
                  <td>From Bank (-)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$from_bank);?></td>
                </tr>
				<tr>
                  <td>To Bank (+)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$to_bank);?></td>
                </tr>
				<tr>
                  <td>From Owner (+)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$from_owner_bank);?></td>
                </tr>
				<tr>
                  <td>To Owner (-)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$to_owner_bank);?></td>
                </tr>

				<tr>
                  <td>Card Sale (+)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$card_sale);?></td>
                </tr>
				<tr>
                  <td>Delivery Charge (+)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$card_delivery_charge);?></td>
                </tr>
				<tr>
                  <td>Due Collection (+)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$bank_credit_collection);?></td>
                </tr>
				<tr>
                  <td>Bank Sale Return (-)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$bank_sale_return);?></td>
                </tr>
				<tr>
                  <td>Purchase Payment (-)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$bank_purchase_payment);?></td>
                </tr>
				<tr>
                  <td>Purchase Bank Return (+)</td>
                  <td style="text-align:right;">0.00</td>
                </tr>
				<tr>
                  <td>Expense Payment (-)</td>
                  <td style="text-align:right;"><?php echo sprintf('%0.2f',$bank_expense_payment);?></td>
                </tr>
				<tr>
                <td>Cash in Bank</td>
                  <td style="text-align:right;">
					<?php 
						$in = $opening_balance+$to_bank+$from_owner_bank+$card_sale+$card_delivery_charge+$bank_credit_collection;
						$out = $from_bank+$to_owner_bank+$bank_sale_return+$bank_purchase_payment+$bank_expense_payment;
						
						echo sprintf('%0.2f',$in-$out);
					?>
				  
				  </td>
                </tr>
              </tbody>
			  </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>	
</div>
