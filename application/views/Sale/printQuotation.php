<!DOCTYPE html>
<html>
<head>
	<title>Quotation</title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets2/bootstrap/css/bootstrap.min.css">
	<script type="text/javascript" src="<?php echo base_url();?>assets/assets2/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/assets2/bootstrap/js/bootstrap.min.js" ></script>
	<style type="text/css">
		table.table_1 tr td{
			padding 	: 0px;
			font-size 	: 12px;
		}
		.table_1 tr td:first-child{
			border-left: 0px solid white;
		}
		.table_1 tr td:last-child{
			border-right: 0px solid white;
		}
		table.table_2 tr td{
			padding 	: 2px;
			font-size 	: 12px;
		}
	</style>

</head>
<body>
	<?php if($listed_product != FALSE){ $total = 0; $ind = 1; ?>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4" style="border: 1px solid #c3c3c3;">
					<div class="row">
						<div>
							<!--img style="width: 100%" src="<?php echo base_url();?>images/pos_logo.JPG"-->
						</div>
						<div id ="pos_top_header">
            				<a href="<?php echo base_url();?>sale_controller/my_sale" autofocus style="text-decoration: none;">
            				<div id ="" style="height: 69px; background: #fff;text-decoration: none;"> 
            					<h5 style="line-height: 13px;text-align:center;margin:0px;background: #fff;text-decoration: none;color:#000;"><?php echo $this->tank_auth->get_shopname();?></h5>
            					<h6 style="line-height: 12px;text-align:center;margin: 5px;background: #fff;text-decoration: none;color:#000;"><?php echo $this->tank_auth->get_shopaddress();?></h6>
            					<h6 style="line-height: 12px;text-align:center;margin: 5px;background: #fff;text-decoration: none;color:#000;"><?php echo $this->tank_auth->get_shopcontact();?></h6>
            				</div> 
            				
            				</a>
            				<!-- <div id ="pos_top_header_right"></div> -->
            			</div>
						<div>
							<table class="table table-bordered table_1">
								<tr>
									<td style="width: 25%; text-align: right;">Invoice ID:</td>
									<td style="width: 25%; text-align: center;"></td>
									<td style="width: 25%; text-align: right;">Date:</td>
									<td style="width: 25%; text-align: center;"><?php echo $date; ?></td>
								</tr>
								<tr>
									<td style="text-align: right;">Customer ID:</td>
									<td style="text-align: center;"></td>
									<td style="text-align: right;">Creator:</td>
									<td style="text-align: center;"><?php echo $creator; ?></td>
								</tr>
							</table>
						</div>
						<div>
							
							<table class="table table-bordered table_2">
								<tr style="background-color: #f0f3f5;/*#00c0ef*/; color: black;/*white/*;">
									<td style="width: 50%;">Name</td>
									<td style="text-align: center;">Quantity</td>
									<td style="text-align: center;">Price</td>
									<td style="text-align: center;">Total</td>
								</tr>
								<?php foreach($listed_product->result() as $tmp){ ?>
									
									<?php if(1 % 2 == 0){?>
									<tr style="background-color: #f0f3f5;">
										<td>
											<?php echo $tmp->item_name ?>
										</td>
										<td style="text-align: center;">
											<?php echo  $tmp->sale_quantity?>
										</td>
										<td style="text-align: right;">
											<?php echo  $tmp->unit_sale_price?>
										</td>
										<td style="text-align: right;">
											<?php 
												$total 		+= ($tmp->unit_sale_price * $tmp->sale_quantity);
												echo  $tmp->unit_sale_price * $tmp->sale_quantity;

											?>
										</td>
									</tr>
									<?php } else {?>
									<tr>
										<td>
											<?php echo $tmp->item_name ?>
										</td>
										<td style="text-align: center;">
											<?php echo  $tmp->sale_quantity?>
										</td>
										<td style="text-align: right;">
											<?php echo  $tmp->unit_sale_price?>
										</td>
										<td style="text-align: right;">
											<?php 
												$total 		+= ($tmp->unit_sale_price * $tmp->sale_quantity);
												echo  $tmp->unit_sale_price * $tmp->sale_quantity;

											?>
										</td>
									</tr>
								<?php } 
								$ind++;
								}?>
								<tr style="background-color: #f0f3f5;">
									<td style="text-align: right;" colspan="3">Total: </td>
									<td style="text-align: right;"><?php echo $total; ?></td>
								</tr>
							</table>
						</div>
						<!--end table-->
						<div style="text-align: center; border-bottom: 1px solid #c3c3c3; font-size: 12px; padding-bottom: 5%;">
							Sold products can be exchanged within 3(three) days. <br>
							Please remember to bring this receipt.<br>
							Thank You For Shopping.
						</div>
						<div style="text-align: center; background-color:; line-height: 12px; font-size: 10px; padding: 2%, 0%; ">
							Software Developed By:<br>IT Lab Solutions Ltd. Call: 8801842485222
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php }?>
</body>
</html>