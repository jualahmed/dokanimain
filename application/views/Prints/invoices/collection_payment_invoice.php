<!DOCTYPE HTML>
<html>

<head>
	<title> Dokani : IT Lab Solutions </title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/posinvoice.css" type="text/css" />
</head>

<body>
	<div id="main_container_body_main">
		<div id="main_container_body_main2">
			<div class="main_container_body">
				<div class="text-center">
					<?php
					$shop_id = $this->tank_auth->get_shop_id();
					$this->db->where('shop_id', $shop_id);
					$shop_info = $this->db->get('shop_setup')->row();
					?>

					<?php $row_data = $payment_info->row(); ?>
					<p><img style="width: 50px;" src="<?php echo base_url(); ?>assets/img/shop/<?php echo $shop_info->logo; ?>" alt=""></p>
					<h4 style="margin: 0;font-weight: bold"><?php echo $shop_info->shop_name; ?></h4>
					<p style="margin: 0;font-size: 12px;"> <?php echo ($shop_info->shop_address) ?> </p>
					<p style="font-size: 12px;font-weight: bold"> <?php echo ($shop_info->shop_contact) ?> </p>

					<h4 style="margin: 0;font-weight: bold;">Payment Receipt : <?php echo $transaction_id; ?></h4>
					<p style="margin: 0px;font-size:11px;"><?php $newDate = date("d-m-Y", strtotime($row_data->date));
															echo $newDate; ?> | <?php $newDate1 = date("h:i A", strtotime($row_data->date));
																				echo $newDate1; ?> | <?php echo $row_data->user_full_name; ?></p>
					<p style="margin: 0px;">Customer : <?php echo $row_data->customer_name; ?></p>
				</div>

				<div id="pos_top_header_thired">
					<?php
					if ($payment_info->num_rows() > 0) {
					?>
						<div class="CSSTableGenerator" style="width:100%;margin:0px auto;float:left">
							<table>
								<tr>
									<td style="text-align:left;">Payment Mode</td>
									<td style="text-align:right;">Amount </td>
								</tr>
								<?php
								foreach ($payment_info->result() as $field) :
								?>
									<tr>
										<td style="text-align:left;">
											<p class="text-capitalize"><?php echo $field->transaction_mode ?></p>
										</td>
										<td style="width:12%;text-align:right;">
											<?php
											echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> ' . round(($field->amount), 2);
											?>
										</td>
									</tr>
								<?php
								endforeach;
								?>
								<tr>
									<td style="text-align:right;font-size: 12px;font-weight: bold;"> 
										<span>Due Amount</span>
									</td>
									<td style="text-align:right; border-left: 1px solid #aaa;font-size: 12px;font-weight: bold;"> 
										<?php echo number_format($due, 2); ?>
									</td>
								</tr>
							</table>
						</div>
					<?php
					}
					?>
				</div>
				<div class="pos_top_header_fotter" style="font-size: 12px;margin-top:5px;">
					<p style="margin: 0;font-size: 9px;text-transform: uppercase;"><i><b><?php echo $in_word; ?> Taka Only.</b></i></p>
					Thank You.
				</div>
				<div style="border-top: 1px solid gray; width: 100%; height: 1px; float:left;"> </div>

				<div class="pos_top_header_fotter" style="line-height:12px;margin-top:5px;">
					Software Developed By:<br />
					<b>IT Lab Solutions Ltd.</b> Call: +8801842485222
				</div>
				<!--End of main container body -->
			</div>
		</div>
	</div>
</body>

</html>