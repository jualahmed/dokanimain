
<div class="content-wrapper">
		<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
		<?php 
		if($status != '' )
		{
        ?>
		<div class="form_field_seperator">
		     <?php 
		         if($status == "successful")
				 {
			 ?>
			     <div class = "successful_msg">
			    	 <p> Entry Successful..!! </p>
			     </div>
			 <?php 
				 }      
		     	 else if($status == "no_invoice_found") 
				 {
			 ?>
			     <div class = "already_exists_msg">
			    	   <p>Invoice Not Exists !!</p>
			     </div>  		
		     <?php
				 }
		   		 else if($status == "failed") 
				 {
		     ?>  
		         <div class = "failed_msg">
			    	  <p>Failed</p>      
			     </div>
			 <?php 
				 }
				 else
				 {
			 ?>  
				   <div class = "validation_msg">   
				   	    
				   	      <?php echo validation_errors();?>  
				   	     
				   </div>	       
		 	   <?php
				 }
			 ?>         
       </div>
        <?php 
		}
		?>
	<section class="content">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Financial Statement Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>Report/specific_date_report_for_financial_statement_1" class="form-horizontal" method="post" enctype="multipart/form-data" id="form_3" autocomplete="off">
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
								<div class="col-sm-4 mt-2">
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
</div>
