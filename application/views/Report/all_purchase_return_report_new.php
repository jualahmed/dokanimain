
<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Purchase Return Report</h3>
					</div>
					<div class="box-body">
						<form aclass="form-horizontal" autocomplete="off" enctype="multipart/form-data">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Distributor</label>
								<div class="col-sm-3">
									<?php 
										echo form_dropdown('distributor_id',$distributor_info, '','class="form-control select8" id="distributor_id" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr",'value' => $bd_date, 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'value' => $bd_date, 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>
								<div class="col-sm-3 mt-2">
									<button type="button" class="btn btn-success btn-sm" name="search_random" id="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	$distributor_id= $this->uri->segment(3);
	$start_date=$this->uri->segment(4);
	$end_date=$this->uri->segment(5);
	if($distributor_id!='' || $start_date!='' || $end_date!='')
	{
	?>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Purchase Return Report</h3>
						<a href="<?php echo base_url();?>Report/download_data_purchase_return/<?php echo $distributor_id;?>/<?php echo $start_date;?>/<?php echo $end_date;?>" id="down" target="_blank" class="btn btn-primary btn-sm pull-right"><i class="fa fa-download"></i> Download</a>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<div class="box-body">
						<div class="col-md-12">
							<table class="table table-bordered reduce_space" >
								<tr>
									<td style="text-align:center;">No</td>
									<td style="text-align:center;">Date</td>
									<td style="text-align:center;">Distributor Name</td>
									<td style="text-align:center;">Product Name</td>
									<td style="text-align:center;">Quantity</td>
									<td style="text-align:center;">Buy Price</td>
								</tr>
								<?php
								$i=1;
								$ii=1;
								foreach($return_main_product->result() as $tmp)
								{
								?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $tmp->doc;?></td>
									<td><?php echo $tmp->distributor_name;?></td>
									<td><b>Main Product:</b> <?php echo $tmp->product_name;?><br>
										<?php
										
										foreach($return_warranty_product[$ii]->result() as $new_tmp)
										{
											echo '<b>Warranty Product:</b> '.$new_tmp->sl_no.'<br>';

										}
										?>
									</td>
									<td style="text-align:center;"><?php echo $tmp->return_quantity;?></td>
									<td style="text-align:center;"><?php echo $tmp->buy_price;?></td>
									
								</tr>
								<?php
									$ii++;
									$i++;
								}
								?>
							</table>
						</div>    
					</div>    
				</div>    
			</div>
		</div>
	</section>
	<?php
	}
	?>
</div>
