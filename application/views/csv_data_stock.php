
<?php 
	 ini_set('memory_limit', '-1');
	//ini_set('MAX_EXECUTION_TIME', '-1');
	ini_set('max_execution_time', 300);
	 header("Content-Type: application/vnd.ms-word");
	header("Expires: 0");
	header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
	header("Content-disposition: attachment; filename=\"Stock.doc\"");
?>
<html>
	<head>
		<title> Dokani: It Lab Solutions </title>
		<link rel="stylesheet" href="<?php echo base_url(); ?>style/transcript_style.css" type="text/css"/> 
	</head>
	
	<body>
		<div id="main">
			<div id="controller">
				<div class="row">
					<table class="simpleTable" style="margin-top:30px;">
						<thead>
							<tr style="background:black;">
								<th colspan="3" style="color:white;">No</th>
								<th colspan="3" style="color:white;">ID</th>
								<th colspan="6" style="text-align:center;color:white;">Product</th>
								<th colspan="6" style="text-align:center;color:white;">Company</th>
								<th colspan="6" style="text-align:center;color:white;">Category</th>
								<th colspan="6" style="text-align:center;color:white;">Type</th>
								<th colspan="6" style="text-align:center;color:white;">Size</th>
								<th colspan="6" style="text-align:center;color:white;">BP</th>
								<th colspan="6" style="text-align:center;color:white;">Stock</th>
							</tr>
						</thead>	
						<tbody>	
						<?php
						$index = 1;
						$total_buy=0;
						$total_quantity = 0;
						print_r($down_data_stock);
						foreach($down_data_stock -> result() as $field):
						?>
							<tr>
								<th colspan="3"> <?php echo $index; ?>  </th>
								<th colspan="3"> <?php echo $field->product_id; ?>  </th>
								<th colspan="6" style="text-align:center;"> <?php echo $field->product_name; ?>  </th>
								<th colspan="6" style="text-align:center;"> <?php echo $field->company_name; ?>  </th>
								<th colspan="6" style="text-align:center;"> <?php echo $field->catagory_name; ?> </th>
								<th colspan="6" style="text-align:center;"> <?php echo $field->product_type; ?> </th>
								<th colspan="6" style="text-align:center;"> <?php echo $field->product_size; ?> </th>
								<th colspan="6" align="center"> <?php echo round($field -> bulk_unit_buy_price,2); ?> </th>
								<th colspan="6" align="center"> <?php echo $field -> stock_amount; ?> </th>
								<?php $grand = round($field -> bulk_unit_buy_price * $field -> stock_amount, 2 );?>
								<?php $total_buy += $grand;?>
								<?php $total_quantity += $field -> stock_amount;?>
							</tr>
						<?php
							$index++;
							endforeach;
							
						?>
						</tbody>
					</table>	
				</div>
				
				<div class="row">
					<h3 class="pageTitleSmall" style="margin:20px 0 5px 0;"> Summary </h3>
					<table class="simpleTable" style="margin-top:30px;">
						<thead>
							<tr style="background:black;">
								<th colspan="3" style="color:white;text-align:center;">Total Quantity</th>
								<th colspan="3" style="color:white;text-align:center;">Total Buy</th>
							</tr>
						</thead>	
						<tbody>	
							<tr>
								<th colspan="3" style="text-align:center;"> <?php echo $total_quantity; ?>  </th>
								<th colspan="3" style="text-align:center;"> <?php echo $total_buy; ?>  </th>
							</tr>
						</tbody>
					</table>
				</div>
			</div> <!---------- END OF DIV CONTROLLER ---------->
		</div>	<!--------- END OF DIV MAIN --------->
	</body>
</html>
