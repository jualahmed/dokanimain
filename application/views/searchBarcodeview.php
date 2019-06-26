<<<<<<< HEAD
<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
<SCRIPT TYPE="text/javascript">          // script for Submit form with enter Key
	document.onkeypress = processKey;     // Added by LIMON ZAMAN date:3-5-14

		function processKey(e)
		{
		if (null == e)
		e = window.event ;
		if (e.keyCode == 13)  {
		submitForm() ;
		}
		}

</SCRIPT>
<script type = "text/javascript">
			//document.write('pream');
 var js_array = <?php echo json_encode($product_info); ?>;
 for(var i in js_array){
 	
    
	//console.log(i + " = " + js_array[i]);

}
</script>
<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$productId = array(
		'name'	=> 'productId',
		'id'	=> 'productId',
		'value' => set_value('productId'),
		'maxlength'	=> 49,
		'tabindex' => 1
	);
	$productName = array(
		'name'	=> 'productName',
		'id'	=> 'product_id',
		'value' => set_value('product_id'),
		'maxlength'	=> 49,
		'tabindex' => 1
	);
	$Quantity = array(
		'name'	=> 'Quantity',
		'id'	=> 'Quantity',
		'value' => set_value('Quantity'),
		'maxlength'	=> 149,
		'tabindex' => 4
	);
?>
<?php 
	if($status != '' )
	{
		 if($status == "exists")
		 {
			 echo '<div class="alert alert-warning alert-dismissible" style="background:#f39c12;">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Already Exist</h4>
				</div>';
		 }
		 else if($status == "successful")
		 {
			 echo '<div class="alert alert-success alert-dismissible" style="background:#00a65a;">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Success</h4>
				</div>';
		 }
		 else if($status == "failed")
		 {
			 echo '<div class="alert alert-danger alert-dismissible" style="background:#dd4b39;">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Failed</h4>
				</div>';
		 }
		 else{
			 
			 echo validation_errors();
		 }
	}
?>
<style>
.form-control-2{
	border-color: #d2d6de;
    border-radius: 0;
    box-shadow: none;
	background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    color: #555;
    display: block;
    font-size: 14px;
    height: 34px;
    line-height: 1.42857;
    padding: 6px 14px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100%;
}
.col-xs-4{
	min-height: 1px;
    padding-left: 150px;
    padding-right: 19px;
    position: relative
}

.col-sm-33{
	width:33%;
	float:left;
	min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    position: relative;
}
.content-2{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 10px;
}
.content-3{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 3px;
}
.col-md-offset-1{
    margin-left: 4.333333%;
}

.listStyl a{
font-size: 16px;
color: #777;
font-family : arial;
}
#product_show{
	min-width: 382px;
}
#product_show li{
background-color: #f7f7f7;
border: 1px solid #00c0ef;
}
.listStyl a:hover{
    background-color: #00c0ef;
    color:#ffffff;
}
.listStyl a:focus {
    background-color: #00c0ef;
	color: #ffffff;
}

input[type="text"]:disabled {
    background: #dddddd;
}

.wrapp {
    width: 100%;
	margin:-6px 0px 0px 0px;
}
.wrapp table {
    width: 100%;
    table-layout: fixed;
}
.wrap {
    width: 100%;
	margin:-19px 0px 0px 0px;
}
.wrap table {
    width: 100%;
    table-layout: fixed;
}
.wrap-1 {
	margin:-8px 0px 0px 0px;
    width: 100%;
}
.wrap-1 table {
    width: 100%;
    table-layout: fixed;
}
table .new_data tr td {
    border: 1.5px solid #e1e1e1;
	background: white;
}
table tr td {
    padding: 5px;
    border: 1.5px solid #e1e1e1;
    width: 100%;
    word-wrap: break-word;
	background: white;
}
table.head tr td {
    color:white;
	background: #494b4c;
	font-size:14px;
	font-family:Sans Pro; 
	font-weight:bold;
}

.new_data_2 tr:nth-child(even) td {
    background-color: #f4f4f4;
}
.new_data_2 tr:nth-child(odd) td {
    background-color: #fff;
}
.inner_table {
	color:#666768;
    height: 35px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    ~overflow-y: auto !important;
}
.inner_table_2 {
	color:#403e3e;
    height: 36px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    ~overflow-y: auto !important;
}
.inner_table_3 {
	color:#403e3e;
    height: 120px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table_3::-webkit-scrollbar {
    width: 8px;
	background-color: #2d3335;
}

.inner_table_3::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: white;
}

.inner_table_3::-webkit-scrollbar-thumb {
   background-color: #448ca6;
   background-image: -webkit-linear-gradient(45deg,rgba(255, 255, 255, .2) 25%,transparent 25%,transparent 50%,rgba(255, 255, 255, .2) 50%,rgba(255, 255, 255, .2) 75%,transparent 75%,transparent)

}
#print{
	float:left;
	width:109px;
	height:24px;
	text-align:center;
	text-decoraton:none;
}
</style>
<section class="content-3" style="margin:0px 0px 0px 0px;">
	<div class="row">
		<div class="col-md-11 col-md-offset-1">
		  <div class="box" style="margin-bottom:4px;">
			<div class="box-header with-border" style="background: #0f77ab;">
				<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"><p>Search Barcode &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; If New Barcode Print, At First Click " <b style="color:#15d1da;">DELETE ALL</b> " Button.</p></h3>
			</div>
			<div class="box-body">
			<form action ="<?php echo base_url();?>product_controller/search_barcode_barcode" method="post" id="form_22" class="form-horizontal">
				<div class="form-group">
                  <label for="inputPassword3" class="col-sm-1 control-label">Barcode</label>
				  <div class="col-sm-3">
                    <?php 
						echo form_input('barcode','','class ="form-control one" id="lock" placeholder="Barcode" title="Barcode" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" autocomplete="off" autofocus="on"');
					?>
                  </div>
				  <label for="inputPassword3" class="col-sm-1 control-label">P.Name</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="Product Name" name="product_name" id="lock333" placeholder="Product Name">
					<input type="hidden" name="product_id" id="pro_id">
                  </div>
				  <label for="inputPassword3" class="col-sm-1 control-label">Product</label>
				  <div class="col-sm-3">
                    <?php
						//echo form_dropdown('product_id', $product_name, '' , 'class = "dropdown"'); 
						echo form_dropdown('product_id', $product_info , '' ,'onchange="document.location.href=this.options[this.selectedIndex].value;" class="form-control-2 select44" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" id="lock5" tabindex="-1" aria-hidden="true"'); 
						echo form_error($productName['name'],'<div style="height:30px;background:red;width:359px;margin-top:-35px;margin-left:262px;font-size:0px;">', '</div>');
					?>	
                  </div>
                </div>
				<div class="box-footer">
					<center>
						<div class="col-sm-22">
							<button type="submit" class="btn btn-success" name="search_random" style="width:100px;"><i class="fa fa-fw fa-save"></i> Submit</button>
							<button type="reset" id="reset_btn" class="btn btn-warning" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
						</div>
					</center>
				</div>
			</form>
			</div>
		</div>
	</div>
</section>
<!--div id = "mid_box_left"  style="width:99%;">	

	<?php echo form_open($this->uri->uri_string());?>
	<div class="form_field_seperator">
		<p> Product ID : </p>
		<?php
			echo form_input($productId ,'',' placeholder="Ex : 1010" style="color:gray;"');
			echo form_error($productId['name'],'<div style="height:30px;background:red;width:364px;margin-top:5px;margin-left:261px;font-size:0px;">', '</div>');
		?>
	
		<p> Product Name : </p>
		<div style="float:left;">
				<input type="hidden" id="purchesEntry_link" value="<?php echo base_url();?>product_controller/purchase_entry1" />
				<input id="products" name="product" type="text"/><br />
								<div style="width: 350px; margin: 0 auto;">
									<ul id="product_show" style="float: left; list-style-type: none; padding: 0px; margin: 0px;">
									</ul>
								</div-->
				
				
				
				
				
<script type = "text/javascript">
$(document).ready(function() {
    $('#products').keyup(function(){
     var keyupval=$('#products').val();
     var length=$('#products').val().length;
     if(length>1)
      purchesEntry(keyupval);
     
      if(length==0)
      $("#product_show").html('');
     });
     
     $(".listStyl a").click(function(){
        $("#product_show").html('');
     });
	 
    });
    function purchesEntry(onkeyUpvalu){
        var i;
        var outputs="";
        var submiturl=$('#purchesEntry_link').val();
            $.ajax({
                url: submiturl,
                type: 'POST',
                dataType: 'json',
                data: {'keyupvalu':onkeyUpvalu},
                success:function(result){
                for(i=0; i<result.length; i++ ){
                  outputs+='<li class="listStyl"><a href="<?php echo base_url(); ?>admin/searchBarcode/'+result[i].product_id+'">'+result[i].product_name+'</a></li>';

				 }
                 $("#product_show").html(outputs);
                 },
                error: function (jXHR, textStatus, errorThrown) {html("")}
            });
        }
</script>	
	<?php
	if($this -> uri -> segment(3) || $product_type =='bulk' || $product_type =='individual')
	{
	?>
		<section class="content-3">
			<div class="row">
				<div class="col-md-11 col-md-offset-1">
					<div class="box" style="margin-bottom:4px;">	 
						<div class="box-body">
							<?php 
								echo form_open($this->uri->uri_string());
								echo form_hidden('product_id', $this -> uri -> segment(3));
								echo form_hidden('unit_sale_price', $sale_price);
								echo form_hidden('general_sale_price', $general_sale_price);
								echo form_hidden('PRODUCT_NAME', $product_name);
								echo form_hidden('special_for_individual',true);
								
							?>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-1 control-label">Quantity</label>
								<div class="col-sm-3">
									<?php
										echo form_input($Quantity ,'',' placeholder="Ex : 5" class ="form-control-2" style="color:gray;"');
										echo form_error($Quantity['name'],'<div style="height:30px;background:red;width:364px;margin-top:5px;margin-left:261px;font-size:0px;">', '</div>');
									?>
								</div>
								<div class="col-sm-22">
									<?php
										echo form_submit('submit', 'Submit','style="width:100px;" class="btn btn-success" onclick="return confirm(\'Are you sure want to Add New Details? \')"'); 
									?>
								</div>
							</div>
							<div class="wrapp">
								<table class="head">
									<tr>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:230%;">Product</td>
									  <!--td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Type</td-->
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Stock</td>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Buy</td>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Sale</td>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">General</td>
									</tr>
								</table>
								<div class="inner_table">
									<table class="new_data_2" id="search_data">
										<tr>
											<td style="width:230%;">  <?php echo $product_name?></td>
											<!--td >  <?php echo $product_type ?></td-->	
											<td >  <?php echo $available_stock ?></td>				
											<td >  <?php echo $buy_price ?></td>			
											<td >  <?php echo $sale_price ?></td>		
											<td >  <?php echo $general_sale_price ?></td>	
										</tr> 
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>	
		</section>
	<?php
	} 
	?>
		<section class="content-3">
			<div class="row">
				<div class="col-md-11 col-md-offset-1">
					<div class="box" style="margin-bottom:4px;">
						<div class="box-body">
							<div class="wrap-1">
								<div class="inner_table_2">
									<table class="new_data">
										<tr>
										  <td colspan="1" style="text-align:left;text-indent:5px;font-size:15px;width:35px;color:#444;font-weight:bold;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"> Delete</td>
										  <td colspan="2" style="text-align:left;text-indent:5px;font-size:15px;width:35px;color:#444;font-weight:bold;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"><a href="<?php echo base_url();?>modify_controller/delete_all_barcode_print_product" class="btn-primary" title="Delete All" id="print" style="text-decoration:none;"><i class="fa fa-fw fa-close"></i> Delete All</a></td>
										  <td colspan="1" style="text-align:left;text-indent:5px;font-size:15px;width:35px;color:#444;font-weight:bold;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"> Print</td>
										  <td colspan="2" style="text-align:left;text-indent:5px;font-size:15px;width:35px;color:#444;font-weight:bold;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"><a href="<?php echo base_url();?>expense_invoice_controller/print_barcode_by_search" target="_blank" class="btn-primary" id="print" style="text-decoration:none;"><i class="fa fa-print"></i> Print</a></td>
										</tr>
									</table>
								</div>
							</div>
							<br>
							<div class="wrap">
								<table class="head">
									<tr>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">S/N</td>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Product ID</td>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:350%;">Product Name</td>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Quantity</td>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Sale Price</td>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Action</td>
									</tr>
								</table>
								<div class="inner_table_3">
									<table class="new_data_2" id="search_data">
										<?php
											if($listed_product->num_rows() > 0){
												$i=1;
											foreach($listed_product->result() as $field){
										?>
										<tr>
												<td >  <?php echo $i;?></td>
												<td >  <?php echo $field -> product_id;?></td>
												<td style="width:350%;">  <?php echo $field -> product_name;?></td>
												<td >  <?php echo $field -> purchase_quantity?></td>				
												<!--td >  <?php echo $field -> product_price?></td-->
												<td >  <?php echo $field -> general_price?></td>
												<td >  <a href="<?php echo base_url();?>modify_controller/delete_barcode_print_product/<?php echo $field -> print_id;?>" class="edit_link" title="delete"><i class="fa fa-fw fa-close"></i></a>
												
												</td>
										</tr> 
											<?php 
											$i++;
											}
											}
											else{ ?>
												<tr><td colspan="5"> No Product Availavle for Print</td></tr>
											<?php 
											}
											?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</section>
</div>
=======
<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
<SCRIPT TYPE="text/javascript">          // script for Submit form with enter Key
	document.onkeypress = processKey;     // Added by LIMON ZAMAN date:3-5-14

		function processKey(e)
		{
		if (null == e)
		e = window.event ;
		if (e.keyCode == 13)  {
		submitForm() ;
		}
		}

</SCRIPT>
<script type = "text/javascript">
			//document.write('pream');
 var js_array = <?php echo json_encode($product_info); ?>;
 for(var i in js_array){
 	
    
	//console.log(i + " = " + js_array[i]);

}
</script>
<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$productId = array(
		'name'	=> 'productId',
		'id'	=> 'productId',
		'value' => set_value('productId'),
		'maxlength'	=> 49,
		'tabindex' => 1
	);
	$productName = array(
		'name'	=> 'productName',
		'id'	=> 'product_id',
		'value' => set_value('product_id'),
		'maxlength'	=> 49,
		'tabindex' => 1
	);
	$Quantity = array(
		'name'	=> 'Quantity',
		'id'	=> 'Quantity',
		'value' => set_value('Quantity'),
		'maxlength'	=> 149,
		'tabindex' => 4
	);
?>
<?php 
	if($status != '' )
	{
		 if($status == "exists")
		 {
			 echo '<div class="alert alert-warning alert-dismissible" style="background:#f39c12;">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Already Exist</h4>
				</div>';
		 }
		 else if($status == "successful")
		 {
			 echo '<div class="alert alert-success alert-dismissible" style="background:#00a65a;">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Success</h4>
				</div>';
		 }
		 else if($status == "failed")
		 {
			 echo '<div class="alert alert-danger alert-dismissible" style="background:#dd4b39;">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Failed</h4>
				</div>';
		 }
		 else{
			 
			 echo validation_errors();
		 }
	}
?>
<style>
.form-control-2{
	border-color: #d2d6de;
    border-radius: 0;
    box-shadow: none;
	background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    color: #555;
    display: block;
    font-size: 14px;
    height: 34px;
    line-height: 1.42857;
    padding: 6px 14px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100%;
}
.col-xs-4{
	min-height: 1px;
    padding-left: 150px;
    padding-right: 19px;
    position: relative
}

.col-sm-33{
	width:33%;
	float:left;
	min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    position: relative;
}
.content-2{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 10px;
}
.content-3{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 3px;
}
.col-md-offset-1{
    margin-left: 4.333333%;
}

.listStyl a{
font-size: 16px;
color: #777;
font-family : arial;
}
#product_show{
	min-width: 382px;
}
#product_show li{
background-color: #f7f7f7;
border: 1px solid #00c0ef;
}
.listStyl a:hover{
    background-color: #00c0ef;
    color:#ffffff;
}
.listStyl a:focus {
    background-color: #00c0ef;
	color: #ffffff;
}

input[type="text"]:disabled {
    background: #dddddd;
}

.wrapp {
    width: 100%;
	margin:-6px 0px 0px 0px;
}
.wrapp table {
    width: 100%;
    table-layout: fixed;
}
.wrap {
    width: 100%;
	margin:-19px 0px 0px 0px;
}
.wrap table {
    width: 100%;
    table-layout: fixed;
}
.wrap-1 {
	margin:-8px 0px 0px 0px;
    width: 100%;
}
.wrap-1 table {
    width: 100%;
    table-layout: fixed;
}
table .new_data tr td {
    border: 1.5px solid #e1e1e1;
	background: white;
}
table tr td {
    padding: 5px;
    border: 1.5px solid #e1e1e1;
    width: 100%;
    word-wrap: break-word;
	background: white;
}
table.head tr td {
    color:white;
	background: #494b4c;
	font-size:14px;
	font-family:Sans Pro; 
	font-weight:bold;
}

.new_data_2 tr:nth-child(even) td {
    background-color: #f4f4f4;
}
.new_data_2 tr:nth-child(odd) td {
    background-color: #fff;
}
.inner_table {
	color:#666768;
    height: 35px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    ~overflow-y: auto !important;
}
.inner_table_2 {
	color:#403e3e;
    height: 36px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    ~overflow-y: auto !important;
}
.inner_table_3 {
	color:#403e3e;
    height: 120px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table_3::-webkit-scrollbar {
    width: 8px;
	background-color: #2d3335;
}

.inner_table_3::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: white;
}

.inner_table_3::-webkit-scrollbar-thumb {
   background-color: #448ca6;
   background-image: -webkit-linear-gradient(45deg,rgba(255, 255, 255, .2) 25%,transparent 25%,transparent 50%,rgba(255, 255, 255, .2) 50%,rgba(255, 255, 255, .2) 75%,transparent 75%,transparent)

}
#print{
	float:left;
	width:109px;
	height:24px;
	text-align:center;
	text-decoraton:none;
}
</style>
<section class="content-3" style="margin:0px 0px 0px 0px;">
	<div class="row">
		<div class="col-md-11 col-md-offset-1">
		  <div class="box" style="margin-bottom:4px;">
			<div class="box-header with-border" style="background: #0f77ab;">
				<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"><p>Search Barcode &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; If New Barcode Print, At First Click " <b style="color:#15d1da;">DELETE ALL</b> " Button.</p></h3>
			</div>
			<div class="box-body">
			<form action ="<?php echo base_url();?>product_controller/search_barcode_barcode" method="post" id="form_22" class="form-horizontal">
				<div class="form-group">
                  <label for="inputPassword3" class="col-sm-1 control-label">Barcode</label>
				  <div class="col-sm-3">
                    <?php 
						echo form_input('barcode','','class ="form-control one" id="lock" placeholder="Barcode" title="Barcode" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" autocomplete="off" autofocus="on"');
					?>
                  </div>
				  <label for="inputPassword3" class="col-sm-1 control-label">P.Name</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="Product Name" name="product_name" id="lock333" placeholder="Product Name">
					<input type="hidden" name="product_id" id="pro_id">
                  </div>
				  <label for="inputPassword3" class="col-sm-1 control-label">Product</label>
				  <div class="col-sm-3">
                    <?php
						//echo form_dropdown('product_id', $product_name, '' , 'class = "dropdown"'); 
						echo form_dropdown('product_id', $product_info , '' ,'onchange="document.location.href=this.options[this.selectedIndex].value;" class="form-control-2 select44" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" id="lock5" tabindex="-1" aria-hidden="true"'); 
						echo form_error($productName['name'],'<div style="height:30px;background:red;width:359px;margin-top:-35px;margin-left:262px;font-size:0px;">', '</div>');
					?>	
                  </div>
                </div>
				<div class="box-footer">
					<center>
						<div class="col-sm-22">
							<button type="submit" class="btn btn-success" name="search_random" style="width:100px;"><i class="fa fa-fw fa-save"></i> Submit</button>
							<button type="reset" id="reset_btn" class="btn btn-warning" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
						</div>
					</center>
				</div>
			</form>
			</div>
		</div>
	</div>
</section>
<!--div id = "mid_box_left"  style="width:99%;">	

	<?php echo form_open($this->uri->uri_string());?>
	<div class="form_field_seperator">
		<p> Product ID : </p>
		<?php
			echo form_input($productId ,'',' placeholder="Ex : 1010" style="color:gray;"');
			echo form_error($productId['name'],'<div style="height:30px;background:red;width:364px;margin-top:5px;margin-left:261px;font-size:0px;">', '</div>');
		?>
	
		<p> Product Name : </p>
		<div style="float:left;">
				<input type="hidden" id="purchesEntry_link" value="<?php echo base_url();?>product_controller/purchase_entry1" />
				<input id="products" name="product" type="text"/><br />
								<div style="width: 350px; margin: 0 auto;">
									<ul id="product_show" style="float: left; list-style-type: none; padding: 0px; margin: 0px;">
									</ul>
								</div-->
				
				
				
				
				
<script type = "text/javascript">
$(document).ready(function() {
    $('#products').keyup(function(){
     var keyupval=$('#products').val();
     var length=$('#products').val().length;
     if(length>1)
      purchesEntry(keyupval);
     
      if(length==0)
      $("#product_show").html('');
     });
     
     $(".listStyl a").click(function(){
        $("#product_show").html('');
     });
	 
    });
    function purchesEntry(onkeyUpvalu){
        var i;
        var outputs="";
        var submiturl=$('#purchesEntry_link').val();
            $.ajax({
                url: submiturl,
                type: 'POST',
                dataType: 'json',
                data: {'keyupvalu':onkeyUpvalu},
                success:function(result){
                for(i=0; i<result.length; i++ ){
                  outputs+='<li class="listStyl"><a href="<?php echo base_url(); ?>site_controller/searchBarcode/'+result[i].product_id+'">'+result[i].product_name+'</a></li>';

				 }
                 $("#product_show").html(outputs);
                 },
                error: function (jXHR, textStatus, errorThrown) {html("")}
            });
        }
</script>	
	<?php
	if($this -> uri -> segment(3) || $product_type =='bulk' || $product_type =='individual')
	{
	?>
		<section class="content-3">
			<div class="row">
				<div class="col-md-11 col-md-offset-1">
					<div class="box" style="margin-bottom:4px;">	 
						<div class="box-body">
							<?php 
								echo form_open($this->uri->uri_string());
								echo form_hidden('product_id', $this -> uri -> segment(3));
								echo form_hidden('unit_sale_price', $sale_price);
								echo form_hidden('general_sale_price', $general_sale_price);
								echo form_hidden('PRODUCT_NAME', $product_name);
								echo form_hidden('special_for_individual',true);
								
							?>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-1 control-label">Quantity</label>
								<div class="col-sm-3">
									<?php
										echo form_input($Quantity ,'',' placeholder="Ex : 5" class ="form-control-2" style="color:gray;"');
										echo form_error($Quantity['name'],'<div style="height:30px;background:red;width:364px;margin-top:5px;margin-left:261px;font-size:0px;">', '</div>');
									?>
								</div>
								<div class="col-sm-22">
									<?php
										echo form_submit('submit', 'Submit','style="width:100px;" class="btn btn-success" onclick="return confirm(\'Are you sure want to Add New Details? \')"'); 
									?>
								</div>
							</div>
							<div class="wrapp">
								<table class="head">
									<tr>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:230%;">Product</td>
									  <!--td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Type</td-->
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Stock</td>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Buy</td>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Sale</td>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">General</td>
									</tr>
								</table>
								<div class="inner_table">
									<table class="new_data_2" id="search_data">
										<tr>
											<td style="width:230%;">  <?php echo $product_name?></td>
											<!--td >  <?php echo $product_type ?></td-->	
											<td >  <?php echo $available_stock ?></td>				
											<td >  <?php echo $buy_price ?></td>			
											<td >  <?php echo $sale_price ?></td>		
											<td >  <?php echo $general_sale_price ?></td>	
										</tr> 
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>	
		</section>
	<?php
	} 
	?>
		<section class="content-3">
			<div class="row">
				<div class="col-md-11 col-md-offset-1">
					<div class="box" style="margin-bottom:4px;">
						<div class="box-body">
							<div class="wrap-1">
								<div class="inner_table_2">
									<table class="new_data">
										<tr>
										  <td colspan="1" style="text-align:left;text-indent:5px;font-size:15px;width:35px;color:#444;font-weight:bold;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"> Delete</td>
										  <td colspan="2" style="text-align:left;text-indent:5px;font-size:15px;width:35px;color:#444;font-weight:bold;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"><a href="<?php echo base_url();?>modify_controller/delete_all_barcode_print_product" class="btn-primary" title="Delete All" id="print" style="text-decoration:none;"><i class="fa fa-fw fa-close"></i> Delete All</a></td>
										  <td colspan="1" style="text-align:left;text-indent:5px;font-size:15px;width:35px;color:#444;font-weight:bold;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"> Print</td>
										  <td colspan="2" style="text-align:left;text-indent:5px;font-size:15px;width:35px;color:#444;font-weight:bold;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"><a href="<?php echo base_url();?>expense_invoice_controller/print_barcode_by_search" target="_blank" class="btn-primary" id="print" style="text-decoration:none;"><i class="fa fa-print"></i> Print</a></td>
										</tr>
									</table>
								</div>
							</div>
							<br>
							<div class="wrap">
								<table class="head">
									<tr>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">S/N</td>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Product ID</td>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:350%;">Product Name</td>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Quantity</td>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Sale Price</td>
									  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Action</td>
									</tr>
								</table>
								<div class="inner_table_3">
									<table class="new_data_2" id="search_data">
										<?php
											if($listed_product->num_rows() > 0){
												$i=1;
											foreach($listed_product->result() as $field){
										?>
										<tr>
												<td >  <?php echo $i;?></td>
												<td >  <?php echo $field -> product_id;?></td>
												<td style="width:350%;">  <?php echo $field -> product_name;?></td>
												<td >  <?php echo $field -> purchase_quantity?></td>				
												<!--td >  <?php echo $field -> product_price?></td-->
												<td >  <?php echo $field -> general_price?></td>
												<td >  <a href="<?php echo base_url();?>modify_controller/delete_barcode_print_product/<?php echo $field -> print_id;?>" class="edit_link" title="delete"><i class="fa fa-fw fa-close"></i></a>
												
												</td>
										</tr> 
											<?php 
											$i++;
											}
											}
											else{ ?>
												<tr><td colspan="5"> No Product Availavle for Print</td></tr>
											<?php 
											}
											?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</section>
</div>
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
<?php $this -> load -> view('include/footer'); ?>