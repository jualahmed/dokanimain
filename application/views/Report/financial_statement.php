<?php 
$sale_price_info=0;
$sale_return_info=0;
$opening_stock=0;
$purchase_total_amount=0;
$purchase_total_amount_for_transport1=0;
$closing_stock=0;
$cost_sale=0;
foreach ($allstatment as $key => $value): ?>
	
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
						<form action ="<?php echo base_url();?>Report/financial_statement" method="post" enctype="multipart/form-data" id="form_3" class="form-horizontal" autocomplete="off">
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-1 control-label">Single</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "specific_date",'class' => "form-control",'id' => "datep", 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<label for="inputPassword3" class="col-sm-1 control-label">Duration</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr", 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'tabindex' => 3, 'title' => "End Date" ));?>
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
							<div class="inner_table_2">
								<table class="new_data">
									<tr>
									  <td colspan="1">S.Date</td>
									  <td colspan="2"><?php echo date("d-m-Y", strtotime($start_date)).nbs(5); ?></td>
									  <td colspan="1">E.Date</td>
									  <td colspan="2"><?php echo date("d-m-Y", strtotime($end_date)); ?></td>
									  <td colspan="2"></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="inner_table_222">
						<div class = "Field_Container_Box">
							<p>Revenue</p>
								<?php 
									echo number_format((float)$sale_price_info - $sale_return_info, 2, '.', '');
								?>
						</div>
						<div id = "mid_box_left" style="width:496px;margin: 0px 0px 0px 64px;" >
							<div class = "TitleBox">
								<div class ="pp">Cost of Sales</div>
							</div>

								<div class = "Field_Container_Box" >
									<div class = "purpose_controller"> Opening Inventory</div>	
									<?php 
										echo '<div class = "h8">'.nbs(10).'<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.$opening_stock.'</div>'; 
									?> 
								</div>
								<div class = "Field_Container_Box" >
									<div class = "purpose_controller">Purchase</div>
									<?php 
										echo number_format((float)$purchase_total_amount, 2, '.', '');
									?> 
								</div>
									
								<div class = "Field_Container_Box" >
									<div class = "purpose_controller">Carriage Inward</div>
									<?php 
										echo number_format((float)$purchase_total_amount_for_transport1, 2, '.', '');
									?>  
								</div>
								<div class = "Field_Container_Box" >
									<p style="width:217px; margin-top:0px; font-size:12px;">Cost of Goods Available for Sale</p>
									<?php
										echo number_format((float)$opening_stock + $purchase_total_amount + $purchase_total_amount_for_transport1, 2, '.', '');
									?>
								</div>
								<div class = "Field_Container_Box">
									<div class = "purpose_controller"> (-) Closing Stock.</div>	
									<?php 
										echo $closing_stock;
									?>
								</div>
								<div class = "Field_Container_Box">
									<p>Cost of Goods Sold</p>
									<?php
										echo number_format((float)$cost_sale - $closing_stock, 2, '.', '');
									?>
								</div>
						</div>	 <!--End of mid box left-->
					
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>		
</div>
