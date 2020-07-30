<!DOCTYPE HTML>
<html>
	<head>
		<title> Dokani: It Lab Solutions </title>
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico"  type="image/x-icon"/>

		<link rel="stylesheet" href="<?php echo base_url(); ?>style/transcript_style.css" type="text/css"/> 
	</head>
	<body>
	<div class="content-wrapper">
	<style>
		.simpleTable{
			text-align:left;
		}
		
		.simpleTable th, .simpleTable td{
			line-height:normal;
			text-align:left;
			font-weight:normal;
		}
		
		#subjectNameList{
			line-height:20px;
		}
		
		
		@media print{
			pageBreak{
				page-break-after:always;
				page-break-inside:avoid;
			}
		}
	</style>
	<?php
		$distributor_id 		= $this->uri->segment(3);
		$customer_id 			= $this->uri->segment(4);
		$purpose_id 			= $this->uri->segment(5);
		$transfer_type 			= $this->uri->segment(6);
		$start 					= $this->uri->segment(7);
		$end 					= $this->uri->segment(8);
		$owner_transfer 		= $this->uri->segment(9);
		$type_id 				= $this->uri->segment(10);
		$employee_id 			= $this->uri->segment(11);
	?>
	<body> 
	 	<div id="main">
			<div id="controller">
				<htmlpageheader name="myheader">
					<div id="header" style="width:100%;">
						<img style="width:10%;" class="schoolLogoHeaderSmall" src="<?php echo base_url();?>images/top_logo.png"/>
						<h1 style="font-size:18px; line-height:normal;width:85%;" class="schoolNameHeaderSmall"> 
							<?php echo $this->tank_auth->get_shopname().' ( '. $this->tank_auth->get_shopaddress().' ) '; ?>
						</h1>
						
					</div>
				</htmlpageheader>
				
				<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
				<sethtmlpagefooter name="myfooter" value="on" />
				<section class="content-3">
					<div class="row">
						<div class="col-md-12">
							<div class="box">	 
								<div class="box-body">
									<?php
										$date1 = $start;
										$new_date = $date1;
										$date2 = $end;
										if(($customer_id!='null' || $purpose_id==1) || ($customer_id!='null' && $purpose_id==1))
										{
											$final_amount_sum = 0;
											$sale_sum = 0;
											$balance_sum = 0;
											$collection_amount_sum = 0;
											$sale_return_amount_sum = 0;
											$paid_amount_sum =0;
											$return_amount_sum =0;
											$final_amount ='';
											
											if($new_date == 'null')
											{
												$new_date = '2016-01-01';
											}
											if($date2 == 'null')
											{
												$today = date('Y-m-d');;
												$date2 = $today;
											}
											$sale_amount_all ='';
											$collection_amount_all ='';
											$sale_return_amount_all ='';
									?>
									<div class="box-header with-border">
										<h3 class="pageTitleSmall" style="margin:10px 0px 5px 0px;"> Sale & Collection Ledger </h3>
									</div>
										<table class="simpleTable">
											<thead>
											<tr class="tableRowBG">
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:62px;">Date</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Customer</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Details</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Total</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Paid</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Balance</th>
											</tr>
											</thead>
											<tbody>	
												<?php
												foreach($ledger_list2['total_balance_amount_customer'] ->result_array() as $field)
												{
													
													$balance_amount_all =$field['int_balance'];
													$balance_sum += $field['int_balance'];
													
													if($balance_amount_all =='')
													{
														$balance_amount_all ='0.00';
													}
													else
													{
														$balance_amount_all =  sprintf("%.2f",$balance_amount_all);
													}
												?>
												<tr>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:62px;"></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Balance Total</th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo $balance_amount_all;?></span></th>
												</tr>
												<?php
												}
												$sale_sum = $balance_sum;
												foreach($ledger_list2['total_sale_amount'] ->result_array() as $field)
												{
													
													$sale_amount_all =$field['total_amount_sale'];
													$sale_sum += $field['total_amount_sale'];
													
													if($sale_amount_all =='')
													{
														$sale_amount_all ='0.00';
													}
													else
													{
														$sale_amount_all =  sprintf("%.2f",$sale_amount_all);
													}
												?>
												<tr>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:62px;"></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Sale & Delivery Charge Total</th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"><?php echo $sale_amount_all;?></span></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$sale_sum);?></span></th>
												</tr>
												<?php
												}
												
												foreach($ledger_list2['total_sale_collection_amount'] ->result_array() as $field2)
												{
													$collection_amount_all =$field2['total_amount_sale_collection'];
													$collection_amount_sum +=round($field2['total_amount_sale_collection']);
													
													if($collection_amount_all =='')
													{
														$collection_amount_all = '0.00';
														$ans = sprintf("%.2f",$sale_amount_all - 0.00 + $balance_sum);
													}
													else
													{
														$collection_amount_all = $collection_amount_all;
														$ans = sprintf("%.2f",$sale_amount_all - $collection_amount_all + $balance_sum);
													}
												?>
													<tr>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:62px;"></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Collection Total</th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$collection_amount_all);?></span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo $ans;?></span></th>
													</tr>
												<?php
												}
												
												$final_amount_sum = $sale_sum;
												$paid_amount_sum  = $collection_amount_sum;
												
												while($new_date <= $date2)
												{
													if(is_array($ledger_list2[$new_date]['total_sale']))
													{
														foreach($ledger_list2[$new_date]['total_sale'] as $field3)
														{
															$final_amount_sum +=$field3['amount'];
															$final_amount =$field3['amount'];
															$balance=$final_amount_sum-$paid_amount_sum;
															$transaction_purpose =$field3['transaction_purpose'];
															if($transaction_purpose =='sale_collection_deleted')
															{
																$transaction_purpose_name = 'Deleted Cheque';
															}
															else if($transaction_purpose =='sale')
															{
																$transaction_purpose_name = 'Sale';
															}
															else if($transaction_purpose =='delivery_charge')
															{
																$transaction_purpose_name = 'Delivery Charge';
															}
													?>
														<tr>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:62px;"><?php echo $field3['date'];?></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $field3['customer_name'];?></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"> <?php echo $transaction_purpose_name.' '. $field3['transaction_mode'].'<br>'.$field3['remarks'] ;?></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$final_amount);?></span></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$balance);?></span></th>
														</tr>
													<?php
													
														}
													}
													if(is_array($ledger_list2[$new_date]['total_collection']))
													{
													
														foreach($ledger_list2[$new_date]['total_collection'] as $field4)
														{
															$paid_amount_sum +=$field4['amount'];
															
															$transaction_id=$field4['transaction_id'];
															$paid_amount=$field4['amount'];
															$transaction_mode=$field4['transaction_mode'];
															$transaction_purpose=$field4['transaction_purpose'];
															$date=$field4['date'];
															$customer_name=$field4['customer_name'];
															$remarks=$field4['remarks'];
															$balance2=$final_amount_sum-$paid_amount_sum;
													?>
													<tr>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:62px;"><?php echo $date;?></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $customer_name;?></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Collection #<?php echo $transaction_purpose.' '.$transaction_mode.'<br>'.$remarks;?></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$paid_amount);?></span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$balance2);?></span></th>
													</tr>
													<?php
													
														}
													}
													$new_date = date('Y-m-d', strtotime($new_date . ' +1 day'));
												}
												
												$final_sum = $final_amount_sum;
												$final_paid = $paid_amount_sum;
												$balance_amount_sum =$final_sum - $final_paid;
										?>
											<tr>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:62px;"></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$final_sum);?></span></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$final_paid);?></span></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$balance_amount_sum);?></span></th>
											</tr>
										</tbody>	
									</table>
									<?php
										}
										else if(($distributor_id!='null' || $purpose_id==3) || ($distributor_id!='null' && $purpose_id ==3))
										{
											$final_amount_sum = 0;
											$purchase_sum = 0;
											$balance_sum = 0;
											$payment_amount_sum = 0;
											$paid_amount_sum =0;
											$final_amount ='';
											
											if($new_date == 'null')
											{
												$new_date = '2016-01-01';
											}
											if($date2 == 'null')
											{
												$today = date('Y-m-d');;
												$date2 = $today;
											}
											$purchase_amount_all ='';
											$payment_amount_all ='';
									?>
									<div class="box-header with-border">
										<h3 class="pageTitleSmall" style="margin:10px 0px 5px 0px;">Purchase & Payment Ledger</h3>
									</div>
									<table class="simpleTable">
										<thead>
											<tr class="tableRowBG">
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Date</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Distributor</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Details</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Total</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Paid</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Balance</th>
											</tr>
										</thead>
										<tbody>
												<?php
												foreach($ledger_list['total_balance_amount_distributor'] ->result_array() as $field)
												{
													
													$balance_amount_all =$field['int_balance'];
													$balance_sum += $field['int_balance'];
													
													if($balance_amount_all =='')
													{
														$balance_amount_all ='0.00';
													}
													else
													{
														$balance_amount_all =  sprintf("%.2f",$balance_amount_all);
													}
												?>
												<tr>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Balance Total</th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"></span></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"></span></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo $balance_amount_all;?></span></th>
												</tr>
												<?php
												}
												$purchase_sum = $balance_sum;
												foreach($ledger_list['total_purchase_amount'] ->result_array() as $field)
												{
													
													$purchase_amount_all =$field['total_amount_purchase'];
													$purchase_sum += $field['total_amount_purchase'];
													
													if($purchase_amount_all =='')
													{
														$purchase_amount_all ='0.00';
													}
													else
													{
														$purchase_amount_all =  sprintf("%.2f",$purchase_amount_all);
													}
												?>
												<tr>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Purchase Total</th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"><?php echo $purchase_amount_all;?></span></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$purchase_sum);?></span></th>
												</tr>
												<?php
												}
												
												foreach($ledger_list['total_purchase_payment_amount'] ->result_array() as $field2)
												{
													$payment_amount_all =$field2['total_amount_purchase_payment'];
													$payment_amount_sum +=round($field2['total_amount_purchase_payment']);
													
													if($payment_amount_all =='')
													{
														$payment_amount_all = '0.00';
														$ans = sprintf("%.2f",$purchase_amount_all - 0.00 + $balance_sum);
													}
													else
													{
														$payment_amount_all = $payment_amount_all;
														$ans = sprintf("%.2f",$purchase_amount_all - $payment_amount_all + $balance_sum);
													}
												?>
													<tr>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Collection Total</th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$payment_amount_all);?></span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo $ans;?></span></th>
													</tr>
												<?php
												}
												$final_amount_sum = $purchase_sum;
												$paid_amount_sum  = $payment_amount_sum;
												while($new_date <= $date2)
												{
													if(is_array($ledger_list[$new_date]['total_purchase']))
													{
														foreach($ledger_list[$new_date]['total_purchase'] as $field3)
														{
															$final_amount_sum +=$field3['amount'];
															$final_amount =$field3['amount'];
															$transaction_purpose =$field3['transaction_purpose'];
															$balance=$final_amount_sum-$paid_amount_sum;
															if($transaction_purpose =='purchase_payment_deleted')
															{
																$transaction_purpose_name = 'Deleted Cheque';
															}
															else if($transaction_purpose =='purchase')
															{
																$transaction_purpose_name = 'Purchase';
															}
													?>
														<tr>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $field3['date'];?></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $field3['distributor_name'];?></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $transaction_purpose_name.' '.$field3['transaction_mode'].'<br>'.$field3['remarks'];?></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$final_amount);?></span></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$balance);?></span></th>
														</tr>
													<?php
													
														}
													}
													if(is_array($ledger_list[$new_date]['total_payment']))
													{
													
														foreach($ledger_list[$new_date]['total_payment'] as $field4)
														{
															$paid_amount_sum +=$field4['amount'];
															
															$transaction_id=$field4['transaction_id'];
															$paid_amount=$field4['amount'];
															$transaction_mode=$field4['transaction_mode'];
															$date=$field4['date'];
															$distributor_name=$field4['distributor_name'];
															$remarks=$field4['remarks'];
															$balance=$final_amount_sum-$paid_amount_sum;
													?>
													<tr>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $date;?></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $distributor_name;?></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Payment <?php echo $transaction_mode .'<br>'.$remarks;?></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$paid_amount);?></span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$balance);?></span></th>
													</tr>
													<?php
													
														}
													}
													$new_date = date('Y-m-d', strtotime($new_date . ' +1 day'));
												}
												
												$final_sum = $final_amount_sum;
												$final_paid = $paid_amount_sum;
												$balance_amount_sum =$final_sum - $final_paid;
										?>
											<tr>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$final_sum);?></span></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$final_paid);?></span></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$balance_amount_sum);?></span></th>
											</tr>
										</tbody>
									</table>
									<?php
										}
										else if(($type_id!='null' || $purpose_id==2) || ($type_id!='null' && $purpose_id ==2))
										{
											$final_amount_sum = 0;
											$expense_sum = 0;
											$expense_payment_amount_sum = 0;
											$paid_amount_sum =0;
											$final_amount ='';
											
											if($new_date == 'null')
											{
												$new_date = '2016-01-01';
											}
											if($date2 == 'null')
											{
												$today = date('Y-m-d');;
												$date2 = $today;
											}
											$expense_amount_all ='';
											$expense_payment_amount_all ='';
									?>
									<div class="box-header with-border">
										<h3 class="pageTitleSmall" style="margin:10px 0px 5px 0px;">Expense & Payment Ledger</h3>
									</div>
									<table class="simpleTable">
										<thead>
											<tr class="tableRowBG">
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Date</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Type / Employee</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Details</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Total</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Paid</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Balance</th>
											</tr>
										</thead>
										<tbody>
												<?php
												foreach($ledger_list3['total_expense_amount'] ->result_array() as $field)
												{
													
													$expense_amount_all =$field['total_amount_expense'];
													$expense_sum += $field['total_amount_expense'];
													
													if($expense_amount_all =='')
													{
														$expense_amount_all ='0.00';
													}
													else
													{
														$expense_amount_all =  sprintf("%.2f",$expense_amount_all);
													}
												?>
												<tr>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Expense Total</th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"><?php echo $expense_amount_all;?></span></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$expense_sum);?></span></th>
												</tr>
												<?php
												}
												
												foreach($ledger_list3['total_expense_payment_amount'] ->result_array() as $field2)
												{
													$expense_payment_amount_all =$field2['total_amount_expense_payment'];
													$expense_payment_amount_sum +=round($field2['total_amount_expense_payment']);
													
													if($expense_payment_amount_all =='')
													{
														$expense_payment_amount_all = '0.00';
														$ans = sprintf("%.2f",$expense_amount_all - 0.00);
													}
													else
													{
														$expense_payment_amount_all = $expense_payment_amount_all;
														$ans = sprintf("%.2f",$expense_amount_all - $expense_payment_amount_all);
													}
												?>
													<tr>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Payment Total</th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$expense_payment_amount_all);?></span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo $ans;?></span></th>
													</tr>
												<?php
												}
												$final_amount_sum = $expense_sum;
												$paid_amount_sum  = $expense_payment_amount_sum;
												while($new_date <= $date2)
												{
													if(is_array($ledger_list3[$new_date]['total_expense']))
													{
														foreach($ledger_list3[$new_date]['total_expense'] as $field3)
														{
															$final_amount_sum +=$field3['amount'];
															$final_amount =$field3['amount'];
															$balance=$final_amount_sum-$paid_amount_sum;
															$transaction_purpose =$field3['transaction_purpose'];
															$employee_name =$field3['employee_name'];
															if($transaction_purpose =='expense_payment_deleted')
															{
																$transaction_purpose_name = 'Deleted Cheque';
															}
															else if($transaction_purpose =='expense')
															{
																$transaction_purpose_name = 'Expense';
															}
													?>
														<tr>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $field3['date'];?></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $field3['type_type'];?><br><?php echo $employee_name;?></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $transaction_purpose_name.' '.$field3['transaction_mode'].'<br>'.$field3['remarks'];?></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$final_amount);?></span></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$balance);?></span></th>
														</tr>
													<?php
													
														}
													}
													if(is_array($ledger_list3[$new_date]['total_expense_payment']))
													{
													
														foreach($ledger_list3[$new_date]['total_expense_payment'] as $field4)
														{
															$paid_amount_sum +=$field4['amount'];
															
															$transaction_id=$field4['transaction_id'];
															$paid_amount=$field4['amount'];
															$transaction_mode=$field4['transaction_mode'];
															$date=$field4['date'];
															$type_type=$field4['type_type'];
															$employee_name=$field4['employee_name'];
															$remarks=$field4['remarks'];
															$balance=$final_amount_sum-$paid_amount_sum;
													?>
													<tr>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $date;?></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $type_type;?><br><?php echo $employee_name;?></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Expense Payment <?php echo $transaction_mode .'<br>'. $remarks;?></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$paid_amount);?></span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$balance);?></span></th>
													</tr>
													<?php
													
														}
													}
													$new_date = date('Y-m-d', strtotime($new_date . ' +1 day'));
												}
												
												$final_sum = $final_amount_sum;
												$final_paid = $paid_amount_sum;
												$balance_amount_sum =$final_sum - $final_paid;
										?>
											<tr>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$final_sum);?></span></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$final_paid);?></span></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$balance_amount_sum);?></span></th>
											</tr>
										</tbody>
									</table>
									<?php
										}
										else if(($transfer_type!='null' || $purpose_id==4) || ($transfer_type!='null' && $purpose_id ==4))
										{
											$final_amount_sum = 0;
											$to_bank_sum = 0;
											$from_bank_amount_sum = 0;
											$paid_amount_sum =0;
											$final_amount ='';
											
											if($new_date == 'null')
											{
												$new_date = '2016-01-01';
											}
											if($date2 == 'null')
											{
												$today = date('Y-m-d');;
												$date2 = $today;
											}
											$to_bank_amount_all ='';
											$from_bank_amount_all ='';
									?>
									<div class="box-header with-border">
										<h3 class="pageTitleSmall" style="margin:10px 0px 5px 0px;">Bank Transfer Ledger</h3>
									</div>
									<table class="simpleTable">
										<thead>
											<tr class="tableRowBG">
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Date</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Provider</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Details</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Total</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Paid</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Balance</th>
											</tr>
										</thead>
										<tbody>
												<?php
												foreach($ledger_list4['total_to_bank_amount'] ->result_array() as $field)
												{
													
													$to_bank_amount_all =$field['total_amount_to_bank'];
													$to_bank_sum += $field['total_amount_to_bank'];
													
													if($to_bank_amount_all =='')
													{
														$to_bank_amount_all ='0.00';
													}
													else
													{
														$to_bank_amount_all =  sprintf("%.2f",$to_bank_amount_all);
													}
												?>
												<tr>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">To Bank Total</th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"><?php echo $to_bank_amount_all;?></span></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$to_bank_sum);?></span></th>
												</tr>
												<?php
												}
												
												foreach($ledger_list4['total_from_bank_amount'] ->result_array() as $field2)
												{
													$from_bank_amount_all =$field2['total_amount_from_bank'];
													$from_bank_amount_sum +=round($field2['total_amount_from_bank']);
													
													if($from_bank_amount_all =='')
													{
														$from_bank_amount_all = '0.00';
														$ans = sprintf("%.2f",$to_bank_amount_all - 0.00);
													}
													else
													{
														$from_bank_amount_all = $from_bank_amount_all;
														$ans = sprintf("%.2f",$to_bank_amount_all - $from_bank_amount_all);
													}
												?>
													<tr>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">From Bank Total</th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$from_bank_amount_all);?></span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo $ans;?></span></th>
													</tr>
												<?php
												}
												$final_amount_sum = $to_bank_sum;
												$paid_amount_sum  = $from_bank_amount_sum;
												while($new_date <= $date2)
												{
													if(is_array($ledger_list4[$new_date]['total_to_bank']))
													{
														foreach($ledger_list4[$new_date]['total_to_bank'] as $field3)
														{
															$final_amount_sum +=$field3['amount'];
															$final_amount =$field3['amount'];
															$balance=$final_amount_sum-$paid_amount_sum;
													?>
														<tr>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $field3['date'];?></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">To Bank #<?php echo $field3['transaction_id'].' '.$field3['transaction_mode'].' '.$field3['bank_name'];?></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$final_amount);?></span></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$balance);?></span></th>
														</tr>
													<?php
													
														}
													}
													if(is_array($ledger_list4[$new_date]['total_from_bank']))
													{
													
														foreach($ledger_list4[$new_date]['total_from_bank'] as $field4)
														{
															$paid_amount_sum +=$field4['amount'];
															
															$transaction_id=$field4['transaction_id'];
															$bank_name=$field4['bank_name'];
															$paid_amount=$field4['amount'];
															$transaction_mode=$field4['transaction_mode'];
															$date=$field4['date'];
															$service_provider_name=$field4['service_provider_name'];
															$balance=$final_amount_sum-$paid_amount_sum;
													?>
													<tr>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $date;?></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">From Bank #<?php echo $transaction_id.' '.$transaction_mode.' '.$bank_name;?></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$paid_amount);?></span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$balance);?></span></th>
													</tr>
													<?php
													
														}
													}
													$new_date = date('Y-m-d', strtotime($new_date . ' +1 day'));
												}
												
												$final_sum = $final_amount_sum;
												$final_paid = $paid_amount_sum;
												$balance_amount_sum =$final_sum - $final_paid;
										?>
											<tr>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$final_sum);?></span></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$final_paid);?></span></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$balance_amount_sum);?></span></th>
											</tr>
										</tbody>
									</table>
									<?php
										}
										
										else if(($owner_transfer!='null' || $purpose_id==5) || ($owner_transfer!='null' && $purpose_id ==5))
										{
											$final_amount_sum = 0;
											$to_owner_sum = 0;
											$from_owner_amount_sum = 0;
											$paid_amount_sum =0;
											$final_amount ='';
											
											if($new_date == 'null')
											{
												$new_date = '2016-01-01';
											}
											if($date2 == 'null')
											{
												$today = date('Y-m-d');;
												$date2 = $today;
											}
											$to_owner_amount_all ='';
											$from_owner_amount_all ='';
									?>
									<div class="box-header with-border">
										<h3 class="pageTitleSmall" style="margin:10px 0px 5px 0px;">Owner Transfer Ledger</h3>
									</div>
									<table class="simpleTable">
										<thead>
											<tr class="tableRowBG">
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Date</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Owner</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Details</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Total</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Paid</th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Balance</th>
											</tr>
										</thead>
										<tbody>
												<?php
												foreach($ledger_list5['total_to_owner_amount'] ->result_array() as $field)
												{
													
													$to_owner_amount_all =$field['total_amount_to_owner'];
													$to_owner_sum += $field['total_amount_to_owner'];
													
													if($to_owner_amount_all =='')
													{
														$to_owner_amount_all ='0.00';
													}
													else
													{
														$to_owner_amount_all =  sprintf("%.2f",$to_owner_amount_all);
													}
												?>
												<tr>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">To Owner Total</th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"><?php echo $to_owner_amount_all;?></span></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
													<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$to_owner_sum);?></span></th>
												</tr>
												<?php
												}
												
												foreach($ledger_list5['total_from_owner_amount'] ->result_array() as $field2)
												{
													$from_owner_amount_all =$field2['total_amount_from_owner'];
													$from_owner_amount_sum +=round($field2['total_amount_from_owner']);
													
													if($from_owner_amount_all =='')
													{
														$from_owner_amount_all = '0.00';
														$ans = sprintf("%.2f",$to_owner_amount_all - 0.00);
													}
													else
													{
														$from_owner_amount_all = $from_owner_amount_all;
														$ans = sprintf("%.2f",$to_owner_amount_all - $from_owner_amount_all);
													}
												?>
													<tr>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">From Owner Total</th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$from_owner_amount_all);?></span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo $ans;?></span></th>
													</tr>
												<?php
												}
												$final_amount_sum = $to_owner_sum;
												$paid_amount_sum  = $from_owner_amount_sum;
												while($new_date <= $date2)
												{
													if(is_array($ledger_list5[$new_date]['total_to_owner']))
													{
														//print_r($ledger_list5[$new_date]['total_to_owner']);
														foreach($ledger_list5[$new_date]['total_to_owner'] as $field3)
														{
															$final_amount_sum +=$field3['amount'];
															$final_amount =$field3['amount'];
															$balance=$final_amount_sum-$paid_amount_sum;
													?>
														<tr>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $field3['date'];?></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $field3['owner_name'];?></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">To Owner #<?php echo $field3['transaction_id'].' '.$field3['transaction_mode'];?></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$final_amount);?></span></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
															<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$balance);?></span></th>
														</tr>
													<?php
														}
													}
													if(is_array($ledger_list5[$new_date]['total_from_owner']))
													{
													
														foreach($ledger_list5[$new_date]['total_from_owner'] as $field4)
														{
															$paid_amount_sum +=$field4['amount'];
															
															$transaction_id=$field4['transaction_id'];
															$paid_amount=$field4['amount'];
															$transaction_mode=$field4['transaction_mode'];
															$date=$field4['date'];
															$owner_name=$field4['owner_name'];
															$balance=$final_amount_sum-$paid_amount_sum;
													?>
													<tr>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $date;?></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"><?php echo $owner_name;?></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">From Owner #<?php echo $transaction_id.' '.$transaction_mode;?></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;">0.00</span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$paid_amount);?></span></th>
														<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$balance);?></span></th>
													</tr>
													<?php
													
														}
													}
													$new_date = date('Y-m-d', strtotime($new_date . ' +1 day'));
												}
												
												$final_sum = $final_amount_sum;
												$final_paid = $paid_amount_sum;
												$balance_amount_sum =$final_sum - $final_paid;
										?>
											<tr>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$final_sum);?></span></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$final_paid);?></span></th>
												<th style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"><?php echo sprintf("%.2f",$balance_amount_sum);?></span></th>
											</tr>
										</tbody>
									</table>
									<?php
										}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</section>
				<htmlpagefooter name="myfooter">
					<div id="printFooter">
						<div class="part70P"> 
							<div class="developPart">
								<img class="companyLogo" src="<?php echo base_url();?>images/itlablogo.png" alt="IT Lab Solutions Ltd."/>
								
								<p> 
									Generated By : <b>Dokani</b> 
									<br/>
									Developed By : <b>IT Lab Solutions Ltd.</b> +8801842485222, www.itlabsolutions.com
								</p> 
							</div>
						</div>
						
						
						<div class="part30P">
							<div class="orgNameBottom textAlginRight">
								<p> <b>&copy; Copyright </b> <br/>  <?php echo $this->tank_auth->get_shopname();?>  </p>
								<p> <?php echo $this->tank_auth->get_shopaddress();?> </p>
							</div>
						</div>
					</div>
				</htmlpagefooter>
				
			</div>
			</div>
	</body><!--end of body-->
</html>		