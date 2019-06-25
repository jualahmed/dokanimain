<?php $this -> load -> view('include/header_for_new_sale'); ?>
<!--script  src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.min.js"></script-->
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
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
	width:21.75%;
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
.col-sm-122{
	width:11.7%;
	float:left;
	min-height: 1px;
    padding-left: 15px;
    padding-right: 0px;
    position: relative;
}
.col-sm-1{
	width:6.333333%;
	float:left;
}
.content-2{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 4px;
}
.content-3{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 4px;
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
.wrap {
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap table {
    width: 100%;
    table-layout: fixed;
}
.wrap-11 {
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap-11 table {
    width: 100%;
    table-layout: fixed;
}
table .new_data tr td {
    border: 1.5px solid #ffe8e8;
	background: white;
}
table tr td {
    padding: 5px;
    border: 1.5px solid #ffe8e8;
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
}
.new_data_2 tr:nth-child(odd) td {
    background-color: #fff;
}
.inner_table {
	color:#666768;
    height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}

.inner_table22 {
	color:#666768;
    height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table_2 {
	color:#403e3e;
    height: 33px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table::-webkit-scrollbar {
    width: 1px;
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
.modal
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
</style>
	<section class="content-2" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-12 ">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Sale Return Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>report_controller/all_sale_return_report_find" class="form-horizontal" method="post" autocomplete="off" enctype="multipart/form-data" id="form_6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Type</label>
								<div class="col-sm-2">
									<select class="form-control select2" name="type" id="type">
										<option value="">Select Type</option>
										<option value="direct">Cash Return</option>
										<option value="indirect">Product Return</option>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Product</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" name="product_name" id="lock22" placeholder="Product Name">
									<input type="hidden" name="product_id" id="pro_id">
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr",'value' => $bd_date, 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'value' => $bd_date, 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-4">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a href="<?php echo base_url();?>report_controller/download_data_return" id="down" style="display:none;" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
<div class="modal" style="display: none">
	<div class="center">
		<img src="<?php echo base_url();?>assets/assets2/spin.gif" id="loaderIcon"/>
	</div>
</div>
<input type="hidden" id="barcode">
<input type="hidden" id="type_id">
<input type="hidden" id="product">
<input type="hidden" id="start">
<input type="hidden" id="end">
<section class="content-3" id="infomsg" style="display:none;">
	<div class="row">
		<div class="col-md-12">
			<div class="box">	 
				<div class="box-body">
					<div class="wrap">
						<table class="head">
							<tr>
							  <td>No</td>
							  <td>Date</td>
							  <td>Return ID</td>
							  <td>Product ID</td>
							  <td>Product</td>
							  <td style="text-align:center;">Quantity</td>
							  <td style="text-align:right;">Sale Price</td>
							  <td style="text-align:right;">Total</td>
							  <td style="text-align:center;">Status</td>
							</tr>
						</table>
						<div class="inner_table" id="search_data">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-1.12.4.js"></script>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-ui.js"></script>
<script>
    $("#lock22").autocomplete({
      source    : function( request, response ) {
        $.ajax( {
          url       : "<?php echo base_url();?>report_controller/search_product",
          dataType  : "json",
          type      : "POST",
          data      : { term: request.term, flag: 1},
          success   : function( result ) { 
                  response( $.map(result, function(item){
                    return{
                      id              : item.id,
                      label           : item.product_name ,
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
          minLength     : 2,
          select        : function (event, ui) {
            var stock   = ui.item.stock;
            if(stock == 0){
                $('#lock22').val("");
                alert("Stock unavailable");
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
		  /* $( "#lock22" ).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li style=\"border-bottom: 1px solid gray;\">" )
      .append( "<div><span class=\"label_style\">" + item.label + "</span><br>" + item.generic_name + "    " +item.catagory_name + "    "+ item.stock + "<br>" + item.company_name + "</div>" ).appendTo( ul );
    }; */
</script>
<script>
 $(document).ready(function() {
	$("#lock22").keyup(function(){
		var length=$('#lock22').val().length;
		 if(length>=1){
			 $("#lock3").prop("disabled", true);
			 $("#lock4").prop("disabled", true);
		 }
		  else{
			 $("#lock3").prop("disabled", false);
			 $("#lock4").prop("disabled", false);
		  }
	});
});
</script>
<script type="text/javascript">
$(document).ready(function() {
		$("#form_6").submit(function(event) {
		event.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		var type_id = $('#type').val();
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
				 $(".modal").show();
			},
			success: function(result) {	
				$(".modal").hide();
				for(i=0; i<result.length; i++)
				{	
					if(type_id=='direct')
					{
						var status_name='Cash Return';
						var unit_sale_price  =parseFloat(Math.round(result[i].unit_sale_price)).toFixed(2);
						var total_sale_return1  =result[i].return_quantity * result[i].unit_sale_price;
						var total_sale_return  =parseFloat(Math.round(total_sale_return1)).toFixed(2);
						output2+='<table class="new_data_2"><tr><td>'+k+'</td><td>'+result[i].return_doc+'</td><td>'+result[i].sale_return_id+'</td><td>'+result[i].product_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].product_name+'">'+result[i].product_name+'</td><td style="text-align:center;">'+result[i].return_quantity+'</td><td style="text-align:right;">'+unit_sale_price+'</td><td style="text-align:right;">'+total_sale_return+'</td><td style="text-align:center;">'+status_name+'</td></tr></table>';
						k++;
					}
					else if(type_id=='indirect')
					{
						var status_name2='Product Return';
						var unit_sale_price  =parseFloat(Math.round(result[i].unit_sale_price)).toFixed(2);
						var total_sale_return1  =result[i].return_quantity * result[i].unit_sale_price;
						var total_sale_return  =parseFloat(Math.round(total_sale_return1)).toFixed(2);
						output2+='<table class="new_data_2"><tr><td>'+k+'</td><td>'+result[i].return_doc+'</td><td>'+result[i].sale_return_id+'</td><td>'+result[i].product_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].product_name+'">'+result[i].product_name+'</td><td style="text-align:center;">'+result[i].return_quantity+'</td><td style="text-align:right;">'+unit_sale_price+'</td><td style="text-align:right;">'+total_sale_return+'</td><td style="text-align:center;">'+status_name2+'</td></tr></table>';
						k++;
					}
					else
					{
						if(result[i].status=='direct')
						{
							var status_name='Cash Return';
							
						}
						else if(result[i].status=='indirect')
						{
							var status_name='Product Return';
						}
							var unit_sale_price  =parseFloat(Math.round(result[i].unit_sale_price)).toFixed(2);
							var total_sale_return1  =result[i].return_quantity * result[i].unit_sale_price;
							var total_sale_return  =parseFloat(Math.round(total_sale_return1)).toFixed(2);
							output2+='<table class="new_data_2"><tr><td>'+k+'</td><td>'+result[i].return_doc+'</td><td>'+result[i].sale_return_id+'</td><td>'+result[i].product_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].product_name+'">'+result[i].product_name+'</td><td style="text-align:center;">'+result[i].return_quantity+'</td><td style="text-align:right;">'+unit_sale_price+'</td><td style="text-align:right;">'+total_sale_return+'</td><td style="text-align:center;">'+status_name+'</td></tr></table>';
							k++;
					}
				}
				if(output2 != '')
				{
					$('#search_data').html(output2);
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#search_data').html("No Data Available");
					$('#infomsg').show();
					$('#down').hide();
				}
				var type1 = $('#type').val();
				var product1 = $('#pro_id').val();
				var start1 = $('#datepickerrr').val();
				var end1 = $('#datepickerr').val();

				$('#type_id').val(type1);
				$('#product').val(product1);
				$('#start').val(start1);
				$('#end').val(end1);
				
				$('.product2').text(product1);
				$('.start2').text(start1);
				$('.end2').text(end1);
				
				
				$('#lock111').val('');
				$('#lock22').val('');

			}
		});
	});
	$("#print").click(function(event2) {
		event2.preventDefault();
		submiturl = $(this).attr('href');
		
		var product = $('#product').val();
		var category = $('#category').val();
		var company = $('#company').val();
		var distributor = $('#distributor').val();
		var start = $('#start').val();
		var end = $('#end').val();

		if(product == ''){
			product = 'null';
		}
		if(category == ''){
			category = 'null';
		}
		if(company == ''){
			company = 'null';
		}
		if(distributor == ''){
			distributor = 'null';
		}
		if(start == ''){
			start = 'null';
		}
		if(end == ''){
			end = 'null';
		}

		window.open(submiturl+'/'+product+'/'+category+'/'+company+'/'+distributor+'/'+start+'/'+end,'_blank');
	});
	
	$("#down").click(function(event2) {
		event2.preventDefault();
		submiturl = $(this).attr('href');
		
		var type_id = $('#type_id').val();
		var product = $('#product').val();
		var start = $('#start').val();
		var end = $('#end').val();

		if(type_id == ''){
			type_id = 'null';
		}
		if(product == ''){
			product = 'null';
		}
		if(start == ''){
			start = 'null';
		}
		if(end == ''){
			end = 'null';
		}

		window.open(submiturl+'/'+product+'/'+start+'/'+end+'/'+type_id,'_blank');
	});
	
});
</script>
<script type="text/javascript">
$(document).ready(function() {
		$("#reset_btn").click(function(event) {
		event.preventDefault();
			$('#lock22').val('');
			$('#datep').val('');
			$('#datep2').val('');
		});
	});
</script>
</div>
<?php $this -> load -> view('include/footer'); ?>