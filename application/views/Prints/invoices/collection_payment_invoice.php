<!DOCTYPE HTML>
<html>
<head>
	<title> Dokani : IT Lab Solutions </title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
</head>
<body> 
	<div class="text-center">
		<div style="width: 400px;margin: left;border: 2px solid;padding: 10px;">
			<div id = "invoice" style="text-align: center;">
				<?php
					$shop_id=$this->tank_auth->get_shop_id();
					$this->db->where('shop_id',$shop_id);
					$shop_info=$this->db->get('shop_setup')->row();
				?>
				<!-- <?php if ($shop_info->invoicelogo): ?>
					<img style="width: 200px;height: 100px;object-fit: contain;" src="<?php echo base_url();?>assets/img/shop/<?php echo $shop_info->invoicelogo ?>">
				<?php else: ?>
					<img style="width: 200px;height: 100px;object-fit: cover;" src="<?php echo base_url();?>assets/img/top_logo2.png">
				<?php endif ?>  -->
				<h3 style="margin-top: 0;"><?php echo $shop_info->shop_name; ?></h3>
			</div>

			<table class="table table-bordered">
				<tr>
					<td><?php $row_data = $collection_payment_info->row(); ?> Payment Receipt : <?php echo $transaction_id; ?></td>
					<td>
					Creator : <?php echo $row_data->username; ?></td>
				</tr>
				<tr>
					<td>Date : <?php $newDate = date("d-m-Y", strtotime($row_data->date));echo $newDate; ?></td>
					<td>Time : <?php $newDate1 = date("h:i A",strtotime($row_data->created_at));echo $newDate1; ?></td>
				</tr>
				<tr>
					<td>Distributor : <?php echo $row_data->distributor_name; ?></td>
					<td>Contact No. : <?php echo $row_data->distributor_contact_no; ?></td>
				</tr>
			</table>
		
			<div class ="pos_top_header_second">
				<div id ="pos_top_header_thired">
					<?php
						if($collection_payment_info -> num_rows() > 0) 
						{
					?>
					<div class="CSSTableGenerator" style="width:100%;margin:0px auto;float:left">
						<table class="table table-bordered">	
							<tr>
								<td>Payment Mode</td>
								<td>Amount </td>
							</tr>
							<?php
								foreach ($collection_payment_info -> result() as $field):
							?>
							<tr>
								<td style="text-align:left;">
									<p class="text-capitalize"><?php echo $field->transaction_mode ?></p>
								</td>
								<td style="width:12%;text-align:right;border-right:0px solid black;">
									<?php 
										echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round(( $field -> amount), 2);
									?> 
								</td>
							</tr>
							<?php
								endforeach;
							?>	
							<tr>
								<td colspan="5" style="text-align:left;"> <i><b><?php echo $in_word; ?> Taka Only.</b></i></td>
							</tr>
						</table>	
					</div>
					<?php  
						}
					?>
				</div>
				<div class ="pos_top_header_fotter" style="background:;line-height:12px;margin-top:5px;"><p> <?php echo ($shop_info->shop_address) ?> </p>Software Developed By:<br /> <b>IT Lab Solutions Ltd.</b> Call: +8801842485222</div>
				<div id ="pos_top_header_fourth" style="width: 50%; float: right;">
				</div>
			</div> <!--End of main container body -->
		</div>
	</div>
</body>
</html>	
