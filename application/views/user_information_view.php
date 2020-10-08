<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
        <div class="mid_box_top">
		   <p> User Information</p>
		</div>

	    <?php
			echo form_open('Login/user_information');
	    ?>	
		<div class="form_field_seperator">
		    <p>User Name:</p>
		    <?php
				echo form_dropdown('result', $user_info,'', 
		 		'onchange="document.location.href=this.options[this.selectedIndex].value;" class="dropdown"');
	        ?>
	    </div>
	    <?php
			if($specific_user -> num_rows > 0)
			{
	    ?>
			<div class="CSSTableGenerator" style="">
				<table >
					<tr>
						<td style = "color:#8DC0EF;"> . </td>
						<td > </td> 
						<td > </td>
						<td > </td>
					</tr>
					<?php
						foreach ($specific_user -> result() as $field):
					?>
					<tr> 
						<td style="text-align:left;text-indent:5px;font-size:13px;text-indent:5px" >  Full Name </td>
						<td style="text-align:left;text-indent:5px;font-size:15px;color:brown" >  <?php echo $field -> user_full_name;?>  </td>
						<td style="text-align:left;text-indent:5px;font-size:13px;text-indent:5px">  Type </td>
						<td style="text-align:left;text-indent:5px;font-size:15px;color:brown">  <?php echo $field -> user_type;?>  </td>
					</tr>
					<tr> 
						<td style="text-align:left;text-indent:5px;font-size:13px;text-indent:5px;width:16%" >  User Name </td>
						<td style="text-align:left;text-indent:5px;font-size:15px;color:brown">  <?php echo $field -> username;?>  </td>
						<td style="text-align:left;text-indent:5px;font-size:13px;text-indent:5px">  User ID</td>
						<td style="text-align:left;text-indent:5px;font-size:15px;color:brown">  <?php echo $field -> id;?>  </td>
						
						
					</tr>
					<tr>
						<td style="text-align:left;text-indent:5px;font-size:13px;text-indent:5px" > Created </td>
						<td style="text-align:left;text-indent:5px;font-size:15px;color:brown">  <?php echo $field -> created;?>  </td>
						<td style="text-align:left;text-indent:5px;font-size:13px;text-indent:5px"> Phone </td>
						<td style="text-align:left;text-indent:5px;font-size:15px;color:brown">  <?php echo $field -> email;?>  </td>
					</tr>
					<tr> 
						<td style="text-align:left;text-indent:5px;font-size:13px;text-indent:5px" > Address </td>
						<td style="text-align:left;text-indent:5px;font-size:15px;color:brown" colspan = 3>  <?php echo $field -> user_address;?>  </td>
					</tr>
					<tr> 
						<td style="text-align:left;text-indent:5px;font-size:13px;text-indent:5px" > Assigned Shop </td>
						<td style="text-align:left;text-indent:5px;font-size:15px;color:brown" colspan = 3>  <?php echo $field -> shop_name;?>  </td>
					</tr>
					<tr> 
						<td style="text-align:left;text-indent:5px;font-size:13px;text-indent:5px" > Shop Address </td>
						<td style="text-align:left;text-indent:5px;font-size:15px;color:brown" colspan = 3>  <?php echo $field -> shop_address;?>  </td>
					</tr>
					<?php
						endforeach;
					?>	
					<tr>
						<td style = "color:#8DC0EF;"> . </td>
						<td >  </td> 
						<td > </td>
						<td > </td>

					</tr>
				</table>
			</div>
		<?php
			}
		?>
