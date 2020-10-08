<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Purchase Receipt Modify</h3>
					</div>
					<div class="box-body">
						<table class="table table-bordered reduce_space" >
							<tbody id="general_info">
								<tr>
									<td style="width: 15%;vertical-align: middle;">Receipt Modify</td>
									<td colspan="3">
										<?php
											echo form_dropdown('result', $purchase_receipt,'', 'class="form-control" style="width:100%;" id="receipt_id"');
										?>
									</td>
								</tr>
							</tbody>
						</table>
						<br>
					<?php
					if($this -> uri -> segment(3))
					{
						foreach($receipt_general_details -> result() as $result):
					?>
							<table class="table table-bordered reduce_space" >
								<tbody id="general_info">
									<tr>
										<td style="width: 15%;vertical-align: middle;">Distributor Name</td>
										<td colspan="3">
											<?php echo  $result -> distributor_name;?>
										</td>
										<td style="width: 15%;vertical-align: middle;"> Receipt ID </td>
										<td colspan="3">
											<?php
												echo  $result -> receipt_id;
												
											?> 
										</td>
									</tr>
									<tr>
										<td style="width: 15%;vertical-align: middle;">Creator's Full Name</td>
										<td colspan="3">
											<?php echo  $result -> user_full_name;?>
										</td>
										<td style="width: 15%;vertical-align: middle;">
											Receipt Date 
										</td>
										<td colspan="3">
											<?php echo  $result -> receipt_date;?>
										</td>
									</tr>
								</tbody>
							</table>
						<br>
						<form action="<?php echo base_url();?>modify/total_purchase_price_modify_apply" method="POST" class="form-horizontal">
							<table class="table table-bordered reduce_space">
								<tbody>
									<tr>
										<td style="vertical-align: middle;" colspan="2">
											Purchase Total
										</td>
										<td colspan="2">
											<?php 
												echo form_hidden('receipt_id' , $result -> receipt_id);
												echo form_input('purchase_amount', $result -> purchase_amount,'class="form-control custom_form_control" id="purchase_amount"  style="text-align:right;" placeholder="Purchase Total"');
											?>
										</td>
										<td style="vertical-align: middle;" colspan="2">
											Discount Amount
										</td>
										<td colspan="2">
											<?php 
												echo form_input('gift_on_purchase', $result -> gift_on_purchase,'class="form-control custom_form_control" maxlength="100" id="gift_on_purchase"  style="text-align:right;" placeholder="Discount Amount"');
											?>
										</td >
										<td style="vertical-align: middle;" colspan="2" >Transport Cost</td>
										<td colspan="2">
											<?php 
												echo form_input('new_transport_cost', $result -> transport_cost,'class="form-control custom_form_control" maxlength="100" id="five"  style="text-align:right;" placeholder="Transport Cost"');
											?>
										</td>
									</tr>
									<tr>
										<td style="vertical-align: middle;" colspan="2">Amount To Be Paid</td>
										<td colspan="4">
											<?php 
												echo form_input('new_grand_total', $result->final_amount,'class="form-control grand_total custom_form_control" id="grand_total" placeholder="Grand Total"  style="text-align:right;" readonly');
											?>
										</td>
										<td style="vertical-align: middle;" colspan="2">
											Product List Total
										</td>
										<td  colspan="4">
											<?php 
												echo form_input('', $result -> total_listing,'class="form-control custom_form_control" maxlength="100" id="" placeholder="Product List Total" Readonly');
											?>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="box-footer" style="background: #0f77ab;">
								<center>
									<button type="submit" class="btn btn-success btn-sm" name="search_random" onclick="return confirm('Are you sure want to Update ?')" id="submit_btn"><i class="fa fa-fw fa-save"></i> Update</button>
								</center>
							</div>	
						</form>							
					</div> 
					<?php
					
					endforeach;
					}
					?>
				</div>
			</div>
		</div>
	</section>
	
</div>




