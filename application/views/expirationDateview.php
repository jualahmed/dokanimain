<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="mid_box_top">
		<p>All Expiration View   </p>	
		<?php
			//echo anchor('report_controller/print_all_company/',img('images/print.png'),'class="mid_box_right_link" target="_blank" title="Print All Company"');
		?>			
	</div>
	 
	 <!-- <div id = "show_result_header">  
	          <div class= "for_id_no">No </div> 
	          <div class= "for_distributor_name"> Company Name  </div>
	           <div class= "for_phone"> Phone Number </div> 
	           <div class= "for_email"> Email </div> 
	           div class= "for_edit">Modify </div--> 
              <!--<div class= "for_stock_status">	Quantity <-Sale Price </div> -->   
	 <!--</div> show_result_div-->

     <div class="CSSTableGenerator" style="">
					<table >
						<tr>
							<td> No </td>
							<td > Expiration Date  </td>
						</tr>
						<tr> 
							<?php
						     	$i = 1; 
						     	//if( $this -> uri -> segment(3))  $i = $this -> uri -> segment(3) + 1;
							    foreach ($all_company -> result() as $field):
						    ?>

							<td > <?php echo $i; ?> </td>
							<td style="text-align:left;text-indent:5px">  <?php 
							$output = false;
							$key = '12e435034534898345';

				   // initialization vector 
							$iv = md5(md5($key));
							$output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($field->expire_date), MCRYPT_MODE_CBC, $iv);
							$decrypted = rtrim($output, "");
							
							
							echo $decrypted;?></td>
						</tr>
							<?php
								 $i++; 
								 endforeach;
							?>	
						<tr>
							<td style = "color:#8DC0EF;"> . </td>
							<td >  </td> 
						</tr>
					</table>		
		</div>
		<?php
		echo form_open('account_controller/expi_dated_selec');
		$js = 'onfocus="this.value=\'\'" ';
		?>
			<div id = "mid_box_left" >
				
				<div class = "TitleBox">
					<p> Select a Specific Date.</p>
				</div>
				
				<div class = "Field_Container_Box" >
					<p>Specific Date:</p>
					<?php
						//echo form_input('purchase_expire_date', set_value('purchase_expire_date','Purchase Expire Date'),$js, 'id="demo3"');
						echo form_input(array('type' => 'text', 'src' => '../../images/date_picker/cal.gif','id'=>"demo3" , 'value' => $bd_date , 'name' => "specific_date",'onclick' => "javascript:NewCssCal('demo3')" ,'class' => "customized_input"));
					?>
				</div>
			
				 <div class = "Field_Container_Box" >
						<div class="button_controller_three">
							<?php
								echo form_submit('submit', 'Submit');
								echo form_reset('reset', 'Reset'); 
								echo form_close();
							?>
						</div>
				</div> 
			</div>
     
	  <div class = "clear"></div>
	  <center>
	  <div id="pagination_view">	  
	  	        <?php
				//	echo $this -> pagination -> create_links();	
	            ?>
	           
	  </div>
	  </center>

	  <?php
	  	function decrypt($encrypted_string, $encryption_key) {
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
		return $decrypted_string;
	}
	  ?>