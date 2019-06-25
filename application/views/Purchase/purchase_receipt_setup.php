<?php $this->load->view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
<?php
	$result = $this->uri->segment(3);
	if($result!='')
	{
		if($result=='success')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Purchase Receipt Successfully Listed", ":)", "success")
					});
			</script>';
		}
		else if($result=='failed')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Something wrong with Purchase Receipt Setup", ":(", "info")
					});
			</script>';
		}
		else if($result=='exist')
		{
			echo '<script>
					$(document).ready(function(){
						swal("This Purchase Receipt is already been Exist", ":)", "info")
					});
			</script>';
		}
		else if($result=='error')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Something Wrong", ":(", "info")
					});
			</script>';
		}
	}
?>
    <section class="content">
      <!-- Small boxes (Stat box) -->
        <div class="row">
       		<div class="col-md-10 col-md-offset-1">
        		<div class="box">
            		<div class="box-header with-border" style="background: #0f77ab;">
              			<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Purchase Receipt Entry</h3>
            		</div>
		            <!-- /.box-header -->
		            <!-- form start -->
             		<div class="box-body">
                		<div class="col-md-12">
                		<?php echo form_open(base_url() . 'purchase/newCreatePurchaseReceipt'); ?>
              			<table class="table table-bordered reduce_space" >
			              	<tr>
			              		<td style="width: 35%;vertical-align: middle;">Distributor:</td>
			              		<td>
			              			<select class="form-control select2 sel_dist distrib" name="distributor_id" style="width: 93%;" required>
					                    <!--option selected="selected"></option-->
						                <?php foreach($distributor_info as $ind => $tmp){ ?><option value="<?php echo $ind; ?>"><?php echo $tmp; ?></option><?php }?>
			                		</select>
			                		<button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#dis_adder_mdl">+</button>
			              		</td>
			              	</tr>
			              	<tr>
			              		<td style="vertical-align: middle;">Purchase Amount:</td>
			              		<td>
			              			<input type="text" name="purchase_amt" style="text-align: right;" class="form-control" id="purchase_amount" placeholder="Ex: 1000" required="on" autocomplete="off">
			              			<span style="font-size: 12px; color: red; text-align: center;"> <?php echo form_error('purchase_amt'); ?> </span>
			              		</td>
			              	</tr>
			              	<tr>
			              		<td style="vertical-align: middle;">Transport Cost:</td>
			              		<td>
			              			<input type="text" name="transport_cst" style="text-align: right;" class="form-control" id="transport_cost" placeholder="Ex: 100" required="on" autocomplete="off">
			              			<span style="font-size: 12px; color: red; text-align: center;"> <?php echo form_error('transport_cst'); ?> </span>
			              		</td>
			              	</tr>
			              	<tr>
			              		<td style="vertical-align: middle;">Discount:</td>
			              		<td>
			              			<input type="text" name="disc" style="text-align: right;" class="form-control" id="discount" placeholder="Ex: 5" autocomplete="off">
			              			<span style="font-size: 12px; color: red; text-align: center;"> <?php echo form_error('disc'); ?> </span>
			              		</td>
			              	</tr>
			              	<tr>
			              		<td style="vertical-align: middle;">Final Amount:</td>
			              		<td>
			              			<input type="text" name="final_amt" style="text-align: right;" class="form-control" id="final_amount" placeholder="Ex: 995" readonly>
			              			<span style="font-size: 12px; color: red; text-align: center;"> <?php echo form_error('final_amt'); ?> </span>
			              		</td>
			              	</tr>
			              	<tr>
			              		<td style="vertical-align: middle;">Date:</td>
			              		<td>
			              			<input id="datepicker" type="text" name="receipt_date" value="<?php echo date('Y-m-d');?>"  class="form-control"  placeholder="Ex: 12-12-16"  required="on"/>
			              			<span style="font-size: 12px; color: red; text-align: center;"> <?php echo form_error('receipt_date'); ?> </span>
			              		</td>
			              	</tr>
							<!--tr>
			              		<td style="vertical-align: middle;">Payment Mode:</td>
								<td>
									<select class="form-control select2" name="payment_mode" id="payment_mode" style="width:100%;">
										<option value="">Select Mode</option>
										<option value="1">Cash</option>
										<option value="2">Cheque</option>
										<option value="3">Card</option>
									</select>
								</td>
			              	</tr>
							<tr>
			              		<td style="vertical-align: middle;">Payment Amount:</td>
			              		<td>
			              			<input type="text" name="payment_amount" style="text-align: right;" class="form-control" id="payment_amount" placeholder="Ex: 1000" autocomplete="off">
			              		</td>
			              	</tr>
							<tr style="display:none;" id="card_id_list">
			              		<td style="vertical-align: middle;">Card:</td>
								<td>
									<select class="form-control select2" name="card_id" id="card_id" style="width:100%;"></select>
								</td>
			              	</tr>
							
             	 		</table>
             	 		<table class="table-bordered reduce_space">
			              	<tr id="result_cheque" style="display:none;">
								<td>My</td>
								<td style="width:25%;">
									<select class="form-control select2" name="my_bank" style="width:100%;" id="my_bank">
										<option value="">Select Bank</option>
										<?php 
											foreach($all_bank ->result() as $field)
											{
											
										?>
										<option value="<?php echo $field->bank_id;?>"><?php echo $field->bank_name;?></option>
										<?php
											}
										?>
									</select>
								</td>
								<td>To</td>
								<td style="width:20%;">
									<select class="form-control select2" name="to_bank" style="width:100%;" id="to_bank">
										<option value="">Select Bank</option>
										<?php 
											foreach($all_bank ->result() as $field)
											{
											
										?>
										<option value="<?php echo $field->bank_id;?>"><?php echo $field->bank_name;?></option>
										<?php
											}
										?>
									</select>
								</td>
								<td>Cheque</td>
								<td>
									<input type="text" name="cheque_no" class="form-control" id="cheque_no_id" placeholder="Cheque No" title="Cheque No" autocomplete="off"></td>
								<td>Date</td>
								<td>
									<input type="text" class="form-control" name="cheque_date" id="datedate" placeholder="Cheque Date" title="Cheque Date" autocomplete="off">
								</td>
			              	</tr-->
             	 		</table>
						<div class="box-footer" style="background: #0f77ab;">
							<center>
								<div class="col-sm-22">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit"><i class="fa fa-fw fa-save"></i> Create</button>
								</div>
							</center>
						</div>
		            	<!-- <?php //echo validation_errors(); ?> -->
		            	<?php echo form_close(); ?>
		            	<div class="modal"  id="dis_adder_mdl">
		    				<div class="modal-dialog">
								<div class="modal-content" style="border-radius: 6px;">
									<div class="modal-header">
								    	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								    		<span aria-hidden="true">&times;</span></button>
								        <h4 class="modal-title">Add Distributor</h4>
								    </div>
								    <form id="distributor_info" action="" method="post">
								    <div class="modal-body">
								    
										<table class="table table-bordered">
							             	<tr>
							             		<td>Distributor Name:</td>
							             		<td>
							             			<input type="text" class="form-control distt_name" id="name" placeholder="Distributor Name" required="on" autocomplete="off">
							             		</td>
							             	</tr>
							             	<tr>
							             		<td>Phone:</td>
							             		<td>
							             			<input type="text" class="form-control" id="phn" placeholder="Phone" required="on" autocomplete="off">
							             		</td>
							             	</tr>
							             	<tr>
							             		<td>E-mail:</td>
							             		<td>
							             			<input type="email" class="form-control" id="mail" placeholder="E-mail" required="on" autocomplete="off">
							             		</td>
							             	</tr>
							             	<tr>
							             		<td>Address:</td>
							             		<td>
							             			<input type="text" class="form-control" id="address" placeholder="Address" required="on" autocomplete="off">
							             		</td>
							             	</tr>
											<tr>
							             		<td>Initial Balance:</td>
							             		<td>
							             			<input type="number" class="form-control" id="int_balance" placeholder="Initial Balance" required="on" autocomplete="off">
							             		</td>
							             	</tr>
							             	<tr>
							             		<td>Description:</td>
							             		<td>
							             			<input type="text" class="form-control" id="des" placeholder="Description" required="on" autocomplete="off">
							             		</td>
							             	</tr>
							       		</table>

								    </div>
								    <div class="modal-footer">
								    	<button type="button" class="btn" data-dismiss="modal">Close</button>
								    	<input type="submit" name="submit" id="submit_info" class="btn btn-info" value="Save">
								    </div>
									</form>
								</div>
							</div>
				    	</div>
              			</div>
                	</div>
            		<!-- /.box-body -->
            		<input type="hidden" id="status" value="<?php echo $status;?>">
            		<!-- /.box-footer -->
          		</div>
        	</div>
      	</div>    
    </section>
    <!-- /.content -->
</div>
<script>
	$(document).ready(function() 
	{
		$("#payment_mode").on("change",function()
			{
				var payment_mode_id = $(this).val();
				var receipt_type = $('#receipt_type').val();
				if(payment_mode_id==2) 
				{	
					$("#result_cheque").show(); 		
					$("#card_id_list").hide(); 		
				}
				else if(payment_mode_id==3) 
				{
					var outputs='';
					var urlx='<?php echo base_url();?>purchase/get_all_card';			
					$.ajax
					({
						url: urlx,
						type: 'POST',
						dataType: 'json',
						data: {'payment_mode_id':payment_mode_id},
						success:function(result)
						{	
							outputs+='<option value="">Select Card</option>';
							for(var i=0; i<result.length; i++ )
							{
							  outputs+='<option value="'+result[i].card_id+'">'+result[i].card_name+'</option>';
							}
							$("#card_id_list").show(); 
							$("#card_id").html(outputs);
							$("#result_cheque").hide();
						},
						error: function (jXHR, textStatus, errorThrown) {}
					});
					
				}
				else if(payment_mode_id==1) 
				{

					$("#card_id_list").hide(); 
					$("#result_cheque").hide(); 							

				}
				else 
				{

					$("#card_id_list").hide(); 
					$("#result_cheque").hide(); 							

				}
			});
			
			
			$('#distributor_info').on('submit', function(event)
			{
				event.preventDefault();
				
				var name      = $('#name').val();
				var phn       = $('#phn').val();
				var mail      = $('#mail').val();
				var address   = $('#address').val();
				var int_balance   = $('#int_balance').val();
				var des       = $('#des').val();
				if(name != '' && phn != '' && mail !='' && address != '' && des != '')
				{

					if(isNaN(name) && !isNaN(phn)&& !isNaN(int_balance) && isNaN(mail) && isNaN(address) && isNaN(des))
					{
					  $.ajax({
					  url     : '<?php echo base_url();?>purchase/newCreateDistributor',
					  type    : 'POST',
					  //cash    : false,
					  data    : {name: name, phn: phn, mail: mail, address: address, des: des, int_balance: int_balance},
					  success : function(info)
					  {
						if(info == 'exist')
						{
							swal(
								'Great!',
								'Data Already exist!',
								'info'
							  );
							select_new_entry_with_id('distributor_info','distributor_id','distrib','distributor_name','distt_name');
							$(".sel_dist").select2();
						}
						else 
						{
							$('#dis_adder_mdl').modal('hide');
							$('#distributor_info').trigger('reset');
							if(info == 'success')
							{
								swal(
									'Great!',
									'Data Successfully added!',
									'success'
								  );
								select_new_entry_with_id('distributor_info','distributor_id','distrib','distributor_name','');
								$(".sel_dist").select2();
							}
							else if(info == 'failed')
							{
								swal(
									'Oops...!',
									'Data already exists!',
									'info'
								  );
							}
						}
					  },
				  });
				  }
				  else
				  {
					swal('Oops...!', 'Invalid data...!', 'warning');
				  }
			  }
			  else
			  {
				swal('Oops...!', 'Data missing...!', 'warning')
			  }
			  
			});
			
			$('#purchase_amount').on('keyup', function()
			{
				  var purchase_amount   = $(this).val();
				  purchase_amount       = parseFloat(purchase_amount);
				  if(!isNaN(purchase_amount)){
					$('#final_amount').val(purchase_amount);
				  }
			});

				$('#transport_cost').on('keyup', function(){
					$(this).val();
				});

				$('#discount').on('keyup', function(){
					var discount        = 0;
					var purchase_amount = $('#purchase_amount').val();

					if(purchase_amount != ''){
					  purchase_amount   = parseFloat(purchase_amount);
					  var tmp_discount  = $(this).val();
					  discount          = parseFloat(tmp_discount);

					  if(!isNaN(purchase_amount) && !isNaN(discount)){

						var discount_amount   = ((purchase_amount * discount)/100);
						var final_amount      = (purchase_amount - discount);
						
						$('#final_amount').val(final_amount);
					  }
					}
					
				});
			  $("[name='distributor_id']").on('change', function(){
				  // $(this).next('input').focus();
				  // $('#purchase_amount').trigger('focus');
			  });
			
			
			
	});
</script>


<?php $this -> load -> view('include/footer'); ?>