<?php $this -> load -> view('include/header_for_new_sale'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
	<?php 
		if($status !=''){
			 if($status == "successful")
			 {
				 echo '<div class="box-body">';
				 echo $this->session->flashdata('msg1');
				 echo '</div>';
			 }
			 else if($status = '')
			 {
				 echo '<div class="box-body">';
				 echo 'No New Update';
				 echo '</div>';
			 }
			 else if($status == "failed")
			 {
				 echo '<div class="box-body">';
				 echo $this->session->flashdata('msg2');
				 echo '</div>';
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

.col-sm-22{
	width:34.75%;
	float:left;
	min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    position: relative;
}
.col-sm-222{
	width:52.8%;
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
    padding: 15px;
}
.content-3{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 15px;
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
        .modal1234
        {
            position: fixed;
            z-index: 999;
            height: 100%;
            width: 100%;
            top: 0;
            left: 0;
            background-color: white;
            filter: alpha(opacity=60);
            opacity: 0.6;
            -moz-opacity: 0.8;
        }
        .center
        {
            z-index: 1000;
            margin: 300px auto;
            width: 350px;
            border-radius: 10px;
            filter: alpha(opacity=100);
            opacity: 1;
            -moz-opacity: 1;
        }
        .center img
        {
            margin:0px 0px 0px 100px;
        }
.wrap {
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap table {
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
    width: 100px;
    word-wrap: break-word;
	background: white;
}
table.head tr td {
    color:white;
	background: #4d89a7;
	font-size:14px;
	font-family:Sans Pro; 
	font-weight:bold;
}

.new_data_2 tr:nth-child(even) td {
    background-color: #e4f1ff;
	cursor: pointer;
}
.new_data_2 tr:nth-child(odd) td {
    background-color: #fff;
	cursor: pointer;
}
.inner_table {
	color:#403e3e;
    height: 235px;
	width: 100%;
	font-size:12px;
	font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table::-webkit-scrollbar {
    width: 4px;
	background-color: #2d3335;
}

.inner_table::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: white;
}

.inner_table::-webkit-scrollbar-thumb {
   background-color: #448ca6;
   background-image: -webkit-linear-gradient(45deg,rgba(255, 255, 255, .2) 25%,transparent 25%,transparent 50%,rgba(255, 255, 255, .2) 50%,rgba(255, 255, 255, .2) 75%,transparent 75%,transparent)

}
</style>
	<section class="content2" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border" style="background:#0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Product Modify</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>modify_controller/all_product_report_find" class="form-horizontal" method="post" enctype="multipart/form-data" id="form_4">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Barcode</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" name="barcode" id="lock" placeholder="Barcode">
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Product</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" name="product_name" id="lock22" placeholder="Product Name">
									<input type="hidden" name="pro_id" id="pro_id">
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Catagory</label>
								<div class="col-sm-3">
									<?php 
										echo form_dropdown('catagory_name', $catagory_name,'','class="form-control three select9" id="lock3" tabindex="-1" aria-hidden="true"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Company</label>
								<div class="col-sm-3">
									<?php 
										echo form_dropdown('company_name', $company_name,'','class="form-control company_name select10 four" id="lock4" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<div class="col-sm-3">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
								</div>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</section>
<div class="modal1234" style="display: none">
	<div class="center">
		<img src="<?php echo base_url();?>assets/assets2/LoaderIcon.gif" id="loaderIcon2"/>
	</div>
</div>
<input type="hidden" id="id_barcode">
<input type="hidden" id="id_product">
<input type="hidden" id="id_catagory">
<input type="hidden" id="id_company">
<section class="content-3" id="infomsg" style="display:none;">
	<div class="row">
		<div class="col-md-12">
			<div class="box">	 
				<div class="box-body">
					<div class="input-group input-group-md">
							<span class="input-group-addon">Product</span>
							<input type="text" class="form-control" id="search_member" placeholder="Search for Product.." title="Type in a name">
						</div>
					<div class="wrap">
						<table class="head">
							<tr>
								<td style="width:45px;text-align:center;">No </td> 
								<td style="width:140px;text-align:center;"> Product </td>
								<td style="width:140px;text-align:center;"> Product(B) </td>
								<td style="text-align:center;"> Size  </td>
								<td style="text-align:center;"> Model  </td>
								<td style="text-align:center;"> Company  </td>
								<td style="text-align:center;"> Catagory </td>
								<td style="text-align:center;"> Barcode  </td>
								<td style="text-align:center;"> Unit  </td>
								<td style="width:54px;text-align:center;"> Stock  </td>
								<td style="width:48px;text-align:center;"> Buy </td>
								<td style="width:48px;text-align:center;"> Sale </td>
								<td style="width:48px;text-align:center;"> Ex </td>
								<td style="width:45px;text-align:center;"></td> 
							</tr>
						</table>
						<div class="inner_table new_data_2" id="search_data">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<div class="modal fade" id="add_shop">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> Update Product</h4>
      </div>
      <div class="modal-body">
        <span id="user-availability-status1" style="display:none;"></span>
        <span id="user-availability-status2" style="display:none;"></span>
		<span id="profile_show_2"></span>
      </div>
    </div>
  </div>
</div>
</section>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-1.12.4.js"></script>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-ui.js"></script>
<script>
$('#search_member').keyup(function() 
{
	var rows = $('#myTable tr');
	var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

	rows.show().filter(function() {
		var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
		return !~text.indexOf(val);
	}).hide();
});
</script>
<script>
    $("#lock22").autocomplete({
      source    : function( request, response ) {
        $.ajax( {
          url       : "<?php echo base_url();?>modify_controller/search_product",
          dataType  : "json",
          type      : "POST",
          data      : { term: request.term, flag: 1},
          success   : function( result ) { 
                  response( $.map(result, function(item){
                    return{
                      id              : item.id,
                      label           : item.product_name +  '(' + item.company_name + ')' +  '(' + item.catagory_name + ')' +  '(' + item.stock + ')',
                      company_name    : item.company_name,
                      catagory_name   : item.catagory_name,
                      sale_price      : item.sale_price,
                      stock           : item.stock,
                      generic_name    : item.generic_name,
                      temp_pro_data   : item.temp_pro_data
                    }
                  }));
                }
              });
          },
          minLength     : 3,
          select        : function (event, ui) {
            var stock   = ui.item.stock;
            var pro_id   = ui.item.id;
            if(stock == 0){
               // $('#lock22').val(0);
                alert("Stock unavailable");
				$('#pro_id').val(pro_id);
                $('#lock22').focus();
            }
			else{
              $('#pro_id').val(ui.item.id);
              $('#price').val(ui.item.sale_price);
              $("#pro_name").val(ui.item.label);
              $("#temp_pro_data").val(ui.item.temp_pro_data);
              $("#temp_pro_qty").val(ui.item.stock);
              $("#product_quantity").focus();
            }
                   
            },

          });
</script>

<script type="text/javascript">
$('#lock').on('keyup', function (efs)
 { 
	efs.defaultPrevented;
	if(efs.keyCode == 13) 
	{
		var barcode = $(this).val();
		var output2 = '';
		var k= 1;
		var profit= 0;
		var profit2= 0;
		var profit_percent= 0;
		var unit_buy_price= 0;
		var unit_sale_price= 0;
		var profit_percent2= 0;
		var total_buy= 0;
		var total_sale= 0;
		
		$.ajax({
			url: '<?php echo base_url()?>modify_controller/all_stock_report_by_barcode',
			type: "POST",
			dataType: 'json',
			data: {'barcode': barcode},
			success: function(result) 
			{	
				$(".modal1234").hide();
				for(i=0; i<result.length; i++)
				{	  
					output2+='<table class="new_data_2" id="myTable"><tr><td style="width:45px;">'+result[i].product_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width:140px;" title="'+result[i].product_name+'">'+result[i].product_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width:140px;" title="'+result[i].product_name_bng+'">'+result[i].product_name_bng+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].product_size+'" >'+result[i].product_size+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].product_model+'" >'+result[i].product_model+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].company_name+'" >'+result[i].company_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].catagory_name+'">'+result[i].catagory_name+'</td><td style="text-align:center;">'+result[i].barcode+'</td><td style="text-align:center;">'+result[i].unit_name+'</td><td style="width:54px;text-align:center;">'+result[i].stock_amount+'</td><td style="width:48px;text-align:right;">'+result[i].bulk_unit_buy_price+'</td><td style="width:48px;text-align:right;">'+result[i].bulk_unit_sale_price+'</td><td style="width:48px;text-align:right;">'+result[i].general_unit_sale_price+'</td><td style="width:45px;text-align:center;"><a href="#" class="modal_load_2" valuu ="'+result[i].product_id+'" data-toggle="modal" data-target="#add_shop"><i class="fa fa-fw fa-edit"></i></a> | <a class="btnDelete" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></a></td></tr></table>';
					var product_idd = result[0].product_id;
				}
				if(output2 != '')
				{
					$('#search_data').html(output2);
					$('#infomsg').show();
				}
				else
				{
					$('#search_data').html("No Data Available");
					$('#infomsg').show();
				}
				var product = $('#pro_id').val();
				var catagory = $('#lock3').val();
				var company = $('#lock4').val();
				var barcode = $('#lock').val();
				$('#id_barcode').val(barcode);	
				$('#id_product').val(product);	
				$('#id_catagory').val(catagory);	
				$('#id_company').val(company);	
				
				var product1 = $('#lock22').val();
				
				//alert(product_idd);
				$('#product').val(product1);	
				$('#product_id_1').val(product_idd);	
				$('.product2').text(product1);
				
				$('#lock3').val('');
				$('#lock3').select2();
				$('#lock4').val('');
				$('#lock4').select2();
				$('#lock22').val('');
				$('#lock').val('');
			}
		});
	} 
});
$(document).ready(function() 
{
	$("#form_4").submit(function(event) {
	event.preventDefault();
	var submiturl = $(this).attr('action');
	var methods = $(this).attr('method');
	var output = '';
	var output2 = '';
	var output3 = '';
	var i=0;
	var k= 1;
		$.ajax({
			url: submiturl,
			type: methods,
			dataType: 'json',
			data: $(this).serialize(),
			beforeSend: function(){
				 $(".modal1234").show();
			},
			success: function(result) 
			{	
				$(".modal1234").hide();
				for(i=0; i<result.length; i++)
				{	  
					output2+='<table class="new_data_2" id="myTable"><tr><td style="width:45px;">'+result[i].product_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width:140px;" title="'+result[i].product_name+'">'+result[i].product_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width:140px;" title="'+result[i].product_name_bng+'">'+result[i].product_name_bng+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].product_size+'" >'+result[i].product_size+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].product_model+'" >'+result[i].product_model+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].company_name+'" >'+result[i].company_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].catagory_name+'">'+result[i].catagory_name+'</td><td style="text-align:center;">'+result[i].barcode+'</td><td style="text-align:center;">'+result[i].unit_name+'</td><td style="width:54px;text-align:center;">'+result[i].stock_amount+'</td><td style="width:48px;text-align:right;">'+result[i].bulk_unit_buy_price+'</td><td style="width:48px;text-align:right;">'+result[i].bulk_unit_sale_price+'</td><td style="width:48px;text-align:right;">'+result[i].general_unit_sale_price+'</td><td style="width:45px;text-align:center;"><a href="#" class="modal_load_2" valuu ="'+result[i].product_id+'" data-toggle="modal" data-target="#add_shop"><i class="fa fa-fw fa-edit"></i></a> | <a class="btnDelete" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></a></td></tr></table>';
					//var product_idd = result[0].product_id;
				}
				if(output2 != '')
				{
					$('#search_data').html(output2);
					$('#infomsg').show();
				}
				else
				{
					$('#search_data').html("No Data Available");
					$('#infomsg').show();
				}

				var product = $('#pro_id').val();
				var catagory = $('#lock3').val();
				var company = $('#lock4').val();
				var barcode = $('#lock').val();
				$('#id_barcode').val(barcode);	
				$('#id_product').val(product);	
				$('#id_catagory').val(catagory);	
				$('#id_company').val(company);	
				//$('#product_id_1').val(product_idd);	
				//$('.product2').text(product1);
				
				$('#lock3').val('');
				$('#lock3').select2();
				$('#lock4').val('');
				$('#lock4').select2();
				$('#lock22').val('');
				$('#lock').val('');
			}
		});
	});
});

			$(document).on("click", ".btnDelete", function() {
				if (confirm("Are you sure?")) {
				var par = $(this).parent().parent();
				var tdId = par.children("td:nth-child(1)");

					var urlx='<?php echo base_url();?>modify_controller/check_delete_product';
					var id=tdId.html();
					 $.ajax({
						url: urlx,
						type: 'POST',
						dataType: 'json',
						data: {'id':id},
						success:function(result)
						{	
							if(result=='Pre Listed')
							{
								alert("You can not edit this product, becasue it is in sale mode.");
							}
							else if(result=='Not Pre Listed')
							{
								//alert('Not Pre');
								deleter(par);
							}
						},
						error: function (jXHR, textStatus, errorThrown) {}
					}); 
				}
				return false;
			});
			
			function deleter(par) {
			var tdId = par.children("td:nth-child(1)");
			var urlx='<?php echo base_url();?>modify_controller/delete_productt';
			var id=tdId.html();
			 $.ajax({
				url: urlx,
				type: 'POST',
				dataType: 'json',
				data: {'id':id},
				success:function(result)
				{	
					alert("Successfully Delete Product.");
				},
				error: function (jXHR, textStatus, errorThrown) {}
			}); 
			
			 par.remove();
			 
			}

</script>
<script type="text/javascript">
	$(document).on("click", ".modal_load_2", function()
	{
		var product_id = $(this).attr('valuu');
		var outputs2="";
		$.ajax({
			url: '<?php echo base_url();?>modify_controller/get_product_info', 
			dataType:'json',
			method: 'POST',
			data: {'product_id' : product_id},
			success: function(result)
			{
				if(result!='Pre_Listed')
				{
					$('#add_shop').modal('show');
					outputs2+='<section class="content"><div class="row"><div class="col-md-12"><div class="box box-info"><form id="form_for_update" enctype="multipart/form-data" role="form"><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Name</label><div class="col-sm-10"><input type="text" class="form-control" id="product_name_1" onBlur="checkAvailability()" name="product_name" value="'+result.product_name+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Name(B)</label><div class="col-sm-10"><input type="text" class="form-control" id="product_name_bng_1" name="product_name_bng" value="'+result.product_name_bng+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Barcode</label><div class="col-sm-10"><input type="text" class="form-control" id="barcode" name="barcode" value="'+result.barcode+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Company</label><div class="col-sm-10"><select name="company_name" class="form-control select7" id = "select_comp" style="width: 100%;"></select></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Catagory</label><div class="col-sm-10"><select name="catagory_name" class="form-control select7" id = "select_cata" style="width: 100%;"></select></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Size</label><div class="col-sm-10"><input type="text" class="form-control" name="product_size" id="product_size" value="'+result.product_size+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Model</label><div class="col-sm-10"><input type="text" class="form-control" name="product_model" id="product_model" value="'+result.product_model+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Unit</label><div class="col-sm-10"><select name="unit_name" class="form-control select8" id = "select_unit" style="width: 100%;"> </select></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Quantity</label><div class="col-sm-10"><input type="text" class="form-control" id="stock_amount" name="stock_amount" value="'+result.stock_amount+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Buy Price</label><div class="col-sm-10"><input type="text" class="form-control" id="bulk_unit_buy_price" name="bulk_unit_buy_price" value="'+result.bulk_unit_buy_price+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Sale Price</label><div class="col-sm-10"><input type="text" class="form-control" id="bulk_unit_sale_price" name="bulk_unit_sale_price" value="'+result.bulk_unit_sale_price+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Ex. Sale Price</label><div class="col-sm-10"><input type="text" class="form-control" id="general_unit_sale_price" name="general_unit_sale_price" value="'+result.general_unit_sale_price+'"></div></div><input type="hidden" name="product_id" id="product_id" value="'+result.product_id+'"><button type="button" id="submit_btn" class="btn btn-block btn-success col-md-offset-2" style="width:116px; margin:10px 0px 0px 206px;">Update</button></form></div></div></div></section>';
					$("#profile_show_2").html(outputs2);
					get_all_company_info(result.company_name);
					get_all_unit_info(result.unit_name);
					get_all_catagory_info(result.catagory_name);
				}
				else{
					$('#add_shop').modal('hide');
					alert('You can not edit this product, becasue it is in sale mode.');
				}
			}
		});
	});
	function get_all_catagory_info(catagory){
		submiturl = '<?php echo base_url();?>modify_controller/get_all_catagory_info';
		var output='';
		var flag;
		$.ajax({
			url: submiturl,
			type: 'POST',
			dataType: 'json',
			data: $(this).serialize(),
			success: function(result) {
				for(var i=0;i<result.length;i++){
					if(result[i].catagory_name == catagory){
						flag = 'selected';
					}
					else{
						flag = '';
					}
					output+='<option value="'+result[i].catagory_name+'" '+flag+'>'+result[i].catagory_name+'</option>';
				}
				
				$('#select_cata').html(output);
				
			}
		});
	}
	
	function get_all_company_info(company_names)
	{
		submiturl = '<?php echo base_url();?>modify_controller/get_all_company_info';
		var output='';
		var flag;
		$.ajax({
			url: submiturl,
			type: 'POST',
			dataType: 'json',
			data: $(this).serialize(),
			success: function(result) 
			{
				for(var i=0;i<result.length;i++){
					if(result[i].company_name == company_names){
						flag = 'selected';
					}
					else{
						flag = '';
					}
					output+='<option value="'+result[i].company_name+'" '+flag+'>'+result[i].company_name+'</option>';
				}
				$('#select_comp').html(output);
			}
		});
	}
	
	function get_all_unit_info(unit_names)
	{
		submiturl = '<?php echo base_url();?>modify_controller/get_all_unit_info';
		var output='';
		var flag;
		$.ajax({
			url: submiturl,
			type: 'POST',
			dataType: 'json',
			data: $(this).serialize(),
			success: function(result) 
			{
				for(var i=0;i<result.length;i++)
				{
					if(result[i].unit_name == unit_names)
					{
						flag = 'selected';
					}
					else{
						flag = '';
					}
					output+='<option value="'+result[i].unit_name+'" '+flag+'>'+result[i].unit_name+'</option>';
				}
				
				$('#select_unit').html(output);
			}
		});
	}
	function get_all_product_report(id_barcode,id_product,id_catagory,id_company)
	{
		submiturl = '<?php echo base_url();?>modify_controller/get_all_product_report';
		var output='';
		var flag;
		$.ajax({
			url: submiturl,
			type: 'POST',
			dataType: 'json',
			data: {'barcode' : id_barcode,'product' : id_product,'catagory' : id_catagory,'company' : id_company},
			success: function(result) 
			{
				for(i=0; i<result.length; i++)
				{	  
					output+='<table class="new_data_2" id="myTable"><tr><td style="width:45px;">'+result[i].product_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width:140px;" title="'+result[i].product_name+'">'+result[i].product_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width:140px;" title="'+result[i].product_name_bng+'">'+result[i].product_name_bng+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].product_size+'" >'+result[i].product_size+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].product_model+'" >'+result[i].product_model+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].company_name+'" >'+result[i].company_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].catagory_name+'">'+result[i].catagory_name+'</td><td style="text-align:center;">'+result[i].barcode+'</td><td style="text-align:center;">'+result[i].unit_name+'</td><td style="width:54px;text-align:center;">'+result[i].stock_amount+'</td><td style="width:48px;text-align:right;">'+result[i].bulk_unit_buy_price+'</td><td style="width:48px;text-align:right;">'+result[i].bulk_unit_sale_price+'</td><td style="width:48px;text-align:right;">'+result[i].general_unit_sale_price+'</td><td style="width:45px;text-align:center;"><a href="#" class="modal_load_2" valuu ="'+result[i].product_id+'" data-toggle="modal" data-target="#add_shop"><i class="fa fa-fw fa-edit"></i></a> | <a class="btnDelete" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></a></td></tr></table>';
				}
				
				$('#search_data').html(output);
				$('#add_shop').modal('hide');
			}
		});
	}
	$(document).on("click", "#submit_btn", function()
	{
		var urlx='<?php echo base_url();?>modify_controller/save_product_info_edit';
		var hid=$('#product_id').val();
		var product=$('#product_name_1').val();
		var product_name_bng=$('#product_name_bng_1').val();
		var product_size=$('#product_size').val();
		var model=$('#product_model').val();
		var company=$('#select_comp').val();
		var catagory=$('#select_cata').val();
		var unit=$('#select_unit').val();
		var barcode=$('#barcode').val();
		var quantity=$('#stock_amount').val();
		var buy_price=$('#bulk_unit_buy_price').val();
		var sale_price=$('#bulk_unit_sale_price').val();
		var ex_sale_price=$('#general_unit_sale_price').val();
		var id_barcode=$('#id_barcode').val();
		var id_product=$('#id_product').val();
		var id_catagory=$('#id_catagory').val();
		var id_company=$('#id_company').val();
		
		$.ajax({
			url: urlx,
			type: 'POST',
			dataType: 'json',
			data: {'hid':hid,'product':product,'product_name_bng':product_name_bng,'product_size':product_size,'product_model':model,'company':company,'catagory':catagory,'unit':unit,'barcode':barcode,'quantity':quantity,'buy_price':buy_price,'sale_price':sale_price,'ex_sale_price':ex_sale_price},
			success:function(result)
			{
				if(id_barcode==''){
					id_barcode='null';
				}
				if(id_product==''){
					id_product='null';
				}
				if(id_catagory==''){
					id_catagory='null';
				}
				if(id_company==''){
					id_company='null';
				}
				get_all_product_report(id_barcode,id_product,id_catagory,id_company);
			}
		}); 
	});

</script>
<script>
function checkAvailability() {
	$("#loaderIcon").show();
	$.ajax({
	url: "<?php echo base_url();?>product_controller/check_product",
	data:'customProductName='+$("#product_name_1").val(),
	type: "POST",
	success:function(data){
		if(data == 'Product Name Available') 
		{
			$('#submit_btn').removeAttr('disabled',false);
			$("#user-availability-status1").html(data).show();
			$("#user-availability-status2").html(data).hide()
			$("#loaderIcon").hide();
		}
		else if (data == 'Product Name Not Available') 
		{
			$('#submit_btn').attr('disabled', true);
			$("#user-availability-status2").html(data).show();
			$("#user-availability-status1").html(data).hide();
			$("#loaderIcon").hide();
		}
	}
	});
}
</script>
<style>
#user-availability-status11{color:#2FC332;}
#user-availability-status22{color:#D60202;}
#user-availability-status1{color:#2FC332;}
#user-availability-status2{color:#D60202;}
</style>
</div>
<?php $this -> load -> view('include/footer'); ?>