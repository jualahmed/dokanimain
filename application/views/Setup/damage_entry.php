<<<<<<< HEAD
<?php $this -> load -> view('include/header'); ?>
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

.col-sm-22{
	width:34.75%;
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
    padding: 15px;
}
</style>
<script>
	 setTimeout(function() {$('.success_new_alert').slideUp("slow");}, 6000);
	 setTimeout(function() {$('.failed_new_alert').slideUp("slow");}, 6000);
	 setTimeout(function() {$('.exist_new_alert').slideUp("slow");}, 6000);
	 setTimeout(function() {$('.error_new_alert').slideUp("slow");}, 6000);
</script>
<?php
$result = $this->uri->segment(3);
if($result!='')
{
	if($result=='success')
	{
		echo '<div class="alert success_new_alert" role="alert" style="text-align:right;width: 235px;float: right;border-color: #ffffff;background-color:#96e6c2;margin-bottom: 0px;">
				  <span style="text-align:center;color: #1e456d;">Damage <strong>Successfully</strong> Listed.</span>
				</div>';
	}
	else if($result=='failed')
	{
		echo '<div class="alert failed_new_alert" role="alert" style="text-align:right;width: 300px;float: right;border-color: #ffffff;background-color:#f9b977;margin-bottom: 0px;">
				  <span style="text-align:center;color: #1e456d;"><strong>Something Wrong</strong> with Damage Setup.</span>
				</div>';
	}
	else if($result=='exist')
	{
		echo '<div class="alert exist_new_alert" role="alert" style="text-align:right;width: 280px;float: right;border-color: #ffffff;background-color:rgb(42, 211, 203);margin-bottom: 0px;">
				  <span style="text-align:center;color: #1e456d;"><strong>This Damage</strong> is already been Exist.</span>
				</div>';
	}
	else if($result=='error')
	{
		echo '<div class="alert error_new_alert" role="alert" style="text-align:right;width: 230px;float: right;border-color: #ffffff;background-color:rgb(255, 132, 132);margin-bottom: 0px;">
				  <span style="text-align:center;color: #1e456d;"><strong>Error found</strong> in Damage setup.</span>
				</div>';
	}
}
?>
	<section class="content" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Damage Setup</h3>
					</div>
					<form class="form-horizontal" action="<?php echo base_url();?>setup/create_damage" method="post">
						<div class="box-body">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Product</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="Product Name" name="product_name" id="lockk3" placeholder="Product Name" autofocus="on">
									<input type="hidden" id="pro_id" name="pro_id">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Buy</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="Product Name" name="buy_price" id="buy" placeholder="Buy" readonly>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Sale</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="Product Name" name="sale" id="sale" placeholder="Sale" readonly>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Stock</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="Product Name" name="stock" id="stock" placeholder="Stock" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Damage</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="Product Name" name="damage_quantity" id="product_quantity" placeholder="Damage Quantity">
								</div>
							</div>
						</div>
						<div class="box-footer" style="background: #0f77ab;">
							<center>
									<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>

							</center>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-1.12.4.js"></script>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-ui.js"></script>
<script>
    $("#lockk3").autocomplete({
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
                      label           : item.product_name,
                      company_name    : item.company_name,
                      catagory_name   : item.catagory_name,
                      sale_price      : item.sale_price,
                      buy_price       : item.buy_price,
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
                alert("Stock unavailable");
				$('#lockk3').val("");
                $('#lockk3').focus();
            }
            else
			{
              $('#pro_id').val(ui.item.id);
              $('#buy').val(ui.item.buy_price);
              $('#sale').val(ui.item.sale_price);
              $("#pro_name").val(ui.item.label);
              $("#temp_pro_data").val(ui.item.temp_pro_data);
              $("#stock").val(ui.item.stock);
              $("#product_quantity").focus();
            }
                   
            },
			
          });
		 
</script>
</div>
=======
<?php $this -> load -> view('include/header'); ?>
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

.col-sm-22{
	width:34.75%;
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
    padding: 15px;
}
</style>
<script>
	 setTimeout(function() {$('.success_new_alert').slideUp("slow");}, 6000);
	 setTimeout(function() {$('.failed_new_alert').slideUp("slow");}, 6000);
	 setTimeout(function() {$('.exist_new_alert').slideUp("slow");}, 6000);
	 setTimeout(function() {$('.error_new_alert').slideUp("slow");}, 6000);
</script>
<?php
$result = $this->uri->segment(3);
if($result!='')
{
	if($result=='success')
	{
		echo '<div class="alert success_new_alert" role="alert" style="text-align:right;width: 235px;float: right;border-color: #ffffff;background-color:#96e6c2;margin-bottom: 0px;">
				  <span style="text-align:center;color: #1e456d;">Damage <strong>Successfully</strong> Listed.</span>
				</div>';
	}
	else if($result=='failed')
	{
		echo '<div class="alert failed_new_alert" role="alert" style="text-align:right;width: 300px;float: right;border-color: #ffffff;background-color:#f9b977;margin-bottom: 0px;">
				  <span style="text-align:center;color: #1e456d;"><strong>Something Wrong</strong> with Damage Setup.</span>
				</div>';
	}
	else if($result=='exist')
	{
		echo '<div class="alert exist_new_alert" role="alert" style="text-align:right;width: 280px;float: right;border-color: #ffffff;background-color:rgb(42, 211, 203);margin-bottom: 0px;">
				  <span style="text-align:center;color: #1e456d;"><strong>This Damage</strong> is already been Exist.</span>
				</div>';
	}
	else if($result=='error')
	{
		echo '<div class="alert error_new_alert" role="alert" style="text-align:right;width: 230px;float: right;border-color: #ffffff;background-color:rgb(255, 132, 132);margin-bottom: 0px;">
				  <span style="text-align:center;color: #1e456d;"><strong>Error found</strong> in Damage setup.</span>
				</div>';
	}
}
?>
	<section class="content" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Damage Setup</h3>
					</div>
					<form class="form-horizontal" action="<?php echo base_url();?>setup/create_damage" method="post">
						<div class="box-body">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Product</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="Product Name" name="product_name" id="lockk3" placeholder="Product Name" autofocus="on">
									<input type="hidden" id="pro_id" name="pro_id">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Buy</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="Product Name" name="buy_price" id="buy" placeholder="Buy" readonly>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Sale</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="Product Name" name="sale" id="sale" placeholder="Sale" readonly>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Stock</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="Product Name" name="stock" id="stock" placeholder="Stock" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Damage</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="Product Name" name="damage_quantity" id="product_quantity" placeholder="Damage Quantity">
								</div>
							</div>
						</div>
						<div class="box-footer" style="background: #0f77ab;">
							<center>
									<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>

							</center>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-1.12.4.js"></script>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-ui.js"></script>
<script>
    $("#lockk3").autocomplete({
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
                      label           : item.product_name,
                      company_name    : item.company_name,
                      catagory_name   : item.catagory_name,
                      sale_price      : item.sale_price,
                      buy_price       : item.buy_price,
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
                alert("Stock unavailable");
				$('#lockk3').val("");
                $('#lockk3').focus();
            }
            else
			{
              $('#pro_id').val(ui.item.id);
              $('#buy').val(ui.item.buy_price);
              $('#sale').val(ui.item.sale_price);
              $("#pro_name").val(ui.item.label);
              $("#temp_pro_data").val(ui.item.temp_pro_data);
              $("#stock").val(ui.item.stock);
              $("#product_quantity").focus();
            }
                   
            },
			
          });
		 
</script>
</div>
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
<?php $this -> load -> view('include/footer'); ?>