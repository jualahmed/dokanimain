<?php 
	ini_set('memory_limit', '-1');
	//ini_set('MAX_EXECUTION_TIME', '-1');
	ini_set('max_execution_time', 300);
?>
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

<html>
	<head>
		<title> Dokani: It Lab Solutions </title>
		<link rel="stylesheet" href="<?php echo base_url(); ?>style/transcript_style.css" type="text/css"/> 
		<!--script src="<?php echo base_url();?>assets/js/jquery.min.js"></script-->
	</head>
	
	<body>
		<div id="main">
			<div id="controller">
				<htmlpageheader name="myheader">
					<div id="header">
						<img style="width:10%;" class="schoolLogoHeaderSmall" src="<?php echo base_url();?>images/top_logo.png"/>
						<h1 style="font-size:18px; line-height:normal;width:90%;" class="schoolNameHeaderSmall"> 
							<?php echo $this->tank_auth->get_shopname().' ( '. $this->tank_auth->get_shopaddress().' ) '; ?>
						</h1>
						<h3 class="pageTitleSmall" style="margin:10px 0px 5px 0px;"> Expense Report </h3>
					</div>
				</htmlpageheader>
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
				<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
				<sethtmlpagefooter name="myfooter" value="on" />

				<div class="row">
					<table class="simpleTable" style="margin-top:30px;">
						<thead>
							<tr class="tableRowBG">
								<th colspan="3" style="text-align:center;">No</th>
								<th colspan="3" style="text-align:center;">Date</th>
								<th colspan="3" style="text-align:center;">Expense ID</th>
								<th colspan="6" style="text-align:center;">Expense</th>
								<th colspan="6" style="text-align:center;">Service By</th>
								<th colspan="6" style="text-align:center;">Expense Amount</th>
							</tr>
						</thead>	
						<tbody>	
						<?php
						$index = 1;
						$total_due=0;
						$total_expense=0;
						foreach($download_data_expense -> result() as $field):
						$total = $field->expense_amount - $field->total_paid;
						?>
							<tr>
								<th colspan="3" style="text-align:center;"> <?php echo $index; ?>  </th>
								<th colspan="3" style="text-align:center;"> <?php echo $field->expense_doc; ?>  </th>
								<th colspan="3" style="text-align:center;"> <?php echo $field->expense_id; ?>  </th>
								<th colspan="6" style="text-align:center;"> <?php echo $field->expense_type; ?>  </th>
								<th colspan="6" style="text-align:center;"> <?php echo $field->service_provider_name; ?>  </th>
								<th colspan="6" style="text-align:right;"> <?php echo sprintf('%0.2f',$field->expense_amount); ?> </th>
								<?php $total_expense += $field->expense_amount;?>
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
							<tr class="tableRowBG">
								<th colspan="3" style="text-align:center;">Total Expense</th>
							</tr>
						</thead>	
						<tbody>	
							<tr>
								<th colspan="3" style="text-align:center;"> <?php echo sprintf('%0.2f',$total_expense); ?>  </th>
							</tr>
						</tbody>
					</table>
				</div>
			</div> <!---------- END OF DIV CONTROLLER ---------->
		</div>	<!--------- END OF DIV MAIN --------->
	</body>
</html>
