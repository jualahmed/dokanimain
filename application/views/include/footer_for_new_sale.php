<style>
	.lead {
		font-size: 18px;
	}
	
	#companyTitle {
		color: #1479B8;
		font-size: 13px;
		transition: 0.6s;
		font-weight: bold;
		text-decoration: none;
	}
</style>			
			
  <footer class="main-footer" style="padding:1px;height:35px;">
	<input name="ret_and_sel" type="hidden" id="ret_and_sel" value="<?php echo base_url();?>extra_controller/retrive_and_select" />
	<input name="ret_and_sel_with_id" type="hidden" id="ret_and_sel_with_id" value="<?php echo base_url();?>extra_controller/retrive_and_select_with_id" />
    <div class="pull-right hidden-xs" style="color: #405367;margin-top:5px;">
      &#169; <?php echo $this->tank_auth->get_shopname(); ?>, <?php echo $this->tank_auth->get_shopaddress(); ?>.
    </div>
	<p style="color: #405367;margin-top:5px;"><i class="fa fa-cog fa-spin fa-lg fa-fw"></i>Dokani Developed by 
		<span class="lead"> 
			<a href="http://www.itlabsolutions.com" target="_blank" id="companyTitle"> 
				<img id="footerLogo" style="width:30px;" src="<?php echo base_url();?>images/itlablogo.png"/> IT Lab Solutions Ltd.<sup>&reg;</sup> 
			</a>
		</span> +8801842485222
	</p>
  </footer>
 </div>
<script src="<?php echo base_url();?>assets/assets2/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->

<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-1.12.4.js"></script> 
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-ui.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets2/sweetalert2/sweetalert2.min.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/assets2/sweetalert2/sweetalert2.min.js"></script>


<script type="text/javascript">

	$(document).ready(function()
	{
		var is_sale_active   = $('#is_sale_active').val();
		if(is_sale_active =='')
		{
			$.ajax({
				url     : '<?php echo base_url()?>sale_controller/select_active_sale',
				type    : "POST",
				success : function(result)
				{  
					$('#sale_new'+result).trigger('click');
				}

			});
		}
	});

	/* Start: Script for sale. */
	$(function(){
	     var i = $('#hid_qty').val();
	     var j = $('#hid_sub_to').val();
	     var k = $('#hid_vat').val();
	        
	     if(i != '' && j != '' && k != ''){
	         $('#number_of_products').val(i);
	         $('#sub_total').val(j);
	         $('#vat').val(k);
	         var re_ajd = $('#hid_return_adjust').val();
	         var tmp = Math.round((parseFloat(j) + parseFloat(k)));

	         if(re_ajd != 0){
	           re_ajd    = Math.round(re_ajd);
	           var pybl  = Math.round(tmp - re_ajd);

	           $('#return_adjust').val(re_ajd);
	           if(pybl > 0)$('#payable').val(pybl);
	           else $('#payable').val(0);
	         }

	         if(!isNaN(tmp)){
	             $('#total').val(tmp);
	             var txt     = convert_number_to_words(tmp) + ' (TK)';
	             $('#inword').val(txt);
	         }
	     }
	});

    /* Start: script for Search by product name. */
   $('#search_by_product_name').on('keyup', function(ev){
		var is_sale_active   = $('#is_sale_active').val();
		var allow_negative_stock   = $('#allow_negative_stock').val();
		if(!is_sale_active && $(this).val().length > 2)
		{
			$('#search_by_product_name').val('');
			swal(
			  'Oops...!',
			  'Please select a sale!',
			  'info'
			  );
		}
	  	var value = $(this).val();
		if(is_sale_active)
		{
			if(ev.which === 13 && value!='')
			{
				var num_of_tr       = $('#selected_products tr').length + 1;
				var barcode         = value;
				//alert(barcode);
				$.ajax({
					url         : "<?php echo base_url();?>sale_controller/search_product",
					type        : 'POST',
					cache		: false,
					data        : { barcode: barcode, num_of_tr: num_of_tr, flag: 3},
					success     : function(result)
					{
						//alert(result);
						$("#selected_products").last().append(result['product_details']);
						$('#search_by_product_name').val("");
						$('#search_by_product_name').focus();
						location.reload();
						//do_calculation(result);
					}
				});
			}
			else
			{
				$("#search_by_product_name").autocomplete({

				   source    : function( request, response ) {
						$.ajax({
						  	url       : "<?php echo base_url();?>sale_controller/search_product2",
						  	dataType  : "json",
						  	type      : "POST",
						  	cache     : false,
						  	data      : { term: request.term, flag: 1},
						 	success   : function( result ) { 
							   response( $.map(result, function(item){
									return{
									  id              : item.id,
									  label           : item.product_name,
									  company_name    : item.company_name,
									  catagory_name   : item.catagory_name,
									  product_size    : item.product_size,
									  product_model   : item.product_model,
									  sale_price      : item.sale_price,
									  mrp_price       : item.mrp_price,
									  buy_price       : item.buy_price,
									  stock           : item.stock,
									  generic_name    : item.generic_name,
									  temp_pro_data   : item.temp_pro_data,
									  product_specification   : item.product_specification
									}
							  	}));
							}
						});
					},

				   minLength     : 1,
				   select        : function (event, ui) {
						var stock   = ui.item.stock;
						if(stock == 0 && allow_negative_stock == 0)
						{
							$('#search_by_product_name').val("");
							alert("Stock unavailable");
							$('#search_by_product_name').focus();
						}
						else{
							var new_sale_price = parseFloat (ui.item.sale_price);
							var new_mrp_price = parseFloat(ui.item.mrp_price);
							var new_buy_price = parseFloat(ui.item.buy_price);
						   $('#price').val(new_sale_price);
						   $('#mrp_price').val(new_mrp_price);
							var sale_price_check = parseFloat(ui.item.mrp_price);
							var stock_check      = parseFloat(ui.item.stock);
							if(sale_price_check==0 && stock_check ==0)
							{
								$("#buy_price_check").prop("disabled", true);
								$("#new_mrp_price").prop("disabled", false);
								$("#new_mrp_price").focus();
							}
							else
							{
								$("#buy_price_check").prop("disabled", true);
								$("#new_mrp_price").prop("disabled", true);
								$("#product_quantity").focus();
							}
						   $('#buy_price_check').val(new_buy_price);
						   $('#new_mrp_price').val(new_sale_price);
						   $("#pro_name").val(ui.item.label);
						   $("#temp_pro_data").val(ui.item.temp_pro_data);
						   $("#temp_pro_id").val(ui.item.id);
						   $("#product_specification").val(ui.item.product_specification);
						   $("#temp_pro_qty").val(ui.item.stock);
						}
					},

				});
					  
				$( "#search_by_product_name" ).autocomplete( "instance" )._renderItem = function( ul, item ) {
				  return $( "<li style=\"border-bottom: 2px solid gray; hover: red;\">" )
				  .append( "<div><span class=\"label_style\">" + item.label +' '+item.catagory_name +' '+item.product_size + "</span><br>" + item.generic_name + "    " +item.catagory_name + "    <span style='color:#00cd6e;'> (Stock: "+ item.stock + ")</span> <span style='color:#00cd6e;'> (Pack: "+ item.product_model + ")</span><br>" + item.company_name + "</div>" ).appendTo( ul );
				};
			}
		}
		else{
			$(this).val('');
			alert('Plz select or create a sale');
		}
   });

	$('#search_by_warran_product_model').on('keyup', function(ev)
	{
		var is_sale_active   = $('#is_sale_active').val();
		if(!is_sale_active && $(this).val().length > 2)
		{
			$('#search_by_warran_product_model').val('');
			swal(
			  'Oops...!',
			  'Please select a sale!',
			  'info'
			  );
		}
		var value = $(this).val();
		if(is_sale_active)
		{
			if(ev.which === 13 && value!='')
			{
				var num_of_tr       = $('#selected_products tr').length + 1;
				var barcode         = value;
				//alert(barcode);
				$.ajax({
					url         : "<?php echo base_url();?>sale_controller/search_product_warranty",
					type        : 'POST',
					data        : { barcode: barcode, num_of_tr: num_of_tr, flag: 3},
					success     : function(result)
					{
						$("#selected_products").last().append(result['product_details']);
						$('#search_by_product_name').val("");
						$('#search_by_product_name').focus();
						location.reload();
						//do_calculation(result);
						
					}
				});
			}
		}
		else
		{
			$(this).val('');
			alert('Plz select or create a sale');
		}
    });
    /* End: Script for search_by_barcode*/
	 /* Start    : delete */
    $('.delete_product').click(function(){
		//var thisTr          = $(this).closest('tr');
        var edit_id 		= $(this).attr('id');
		var kval 			= edit_id.substring(6, 50);
		var product_id      = $('#pro_duct_idd'+kval).val();
		var product_qnty    = $('#quantti_id'+kval).val();
		swal({
            title               : 'Are you sure?',
            text                : "You won't be able to revert this!",
            type                : 'warning',
            showCancelButton    : true,
            confirmButtonColor  : '#db8b0b',
            cancelButtonColor   : '#419641',
            confirmButtonText   : 'Yes',
            cancelButtonText    : 'No'
        }).then(function () {

            $.ajax({
                url     : '<?php echo base_url()?>sale_controller/removeProduct',
                type    : "POST",
                cache   : false,
                data    : { product_id: product_id, Quantity: product_qnty },
                success : function(result){
					swal(
                      'Deleted!',
                      'Data Delete Successfully..!)',
                      'success'
                    );
					//thisTr.remove();	
					location.reload();
                }

            });
        })
    });
    /* End      : delete */
    /* Start: Customer Selection. */
    /* var customer_available   = [ <?php echo $customer_info; ?> ]

    $('#select_customer').autocomplete({
                  
      source    : customer_available,
      minLength : 0,
      select    : function(event, ui)
	  {
          $('#selected_customer_name').val(ui.item.label);
          $('#selected_customer_phn').val(ui.item.customer_contact_no);
          $('#selected_customer_id').val(ui.item.id);
          
      },
                                
    }).autocomplete( "widget" ).addClass( "autocomplete_custom_cls_for_customer" ); */
    
    /* End: Customer Selection. */

    /* Start: Product quantity */
    $('#new_mrp_price').on('keydown', function (e)
	{
        if(e.keyCode === 13) 
		{
			$("#product_quantity").focus();
		}
	});
	$('#product_quantity').on('keydown', function (e)
	{
        if(e.keyCode === 13) 
		{
			
				var num_of_tr       = $('#selected_products tr').length;
				var stock           = $("#temp_pro_qty").val();         var cstock          = parseFloat(stock);
				var qnty            = $('#product_quantity').val();     var rstock          = parseFloat(qnty);
				var str_Price       = $('#price').val();                var pro_price       = parseFloat(str_Price);
				var mrp_price   	= $('#mrp_price').val();        	var mrp_price   	= parseFloat(mrp_price);
				var str_mrp_Price   = $('#new_mrp_price').val();        var pro_mrp_price   = parseFloat(str_mrp_Price);
				var str_buy_Price   = $('#buy_price').val();            var str_buy_Price   = parseFloat(str_buy_Price);
				var str_sub_total   = $('#sub_total').val();            var tmp_sub_total   = parseFloat(str_sub_total);
				var str_total_vat   = $('#vat').val();                  var total_vat       = parseFloat(str_total_vat);
				var str_num_of_pro  = $('#number_of_products').val();   var num_of_pro      = parseInt(str_num_of_pro);
				var return_adjust   = $('#return_adjust').val();
				var product_specification   = $('#product_specification').val();
				var pro_id   = $("#temp_pro_id").val();
				var value_added_tax = parseFloat($('#value_added_tax').val());
				
				if(qnty != '' && !isNaN(qnty) && qnty > 0 && $("#temp_pro_data").val() != '')
				{
					tmp_sub_total       = Math.round(tmp_sub_total);
					total_vat           = Math.round(total_vat);

					var old_qnty        = "";
					var price           = "";
					var new_qnty        = "";
					var new_stock       = "";
					var new_price       = "";
					var selected_row    = "";
					var temp_amount     = "";
					var total_2         = "";
					var tmp_vat         = 0;

					if(str_num_of_pro != ''){
						num_of_pro += rstock;
						$('#number_of_products').val(num_of_pro);
					}
					else{
						$('#number_of_products').val(rstock);
					}
						
					var vat = ((pro_price * rstock *  value_added_tax) / 100);
					if(str_total_vat != '')vat += total_vat;
						
					vat = Math.round(vat);
					var selected_producted  = $("#pro_name").val();
					var flg                 = false;

					$('#selected_products tr').each(function() {
						if(selected_producted == $(this).find("td:nth-child(1)").text()){
							flg           = true;
							old_qnty      = $(this).find("td:nth-child(3)").text();
							price         = $(this).find("td:nth-child(4)").text();
							selected_row  = $(this);

							price         = parseFloat(price);
							old_qnty      = parseInt(old_qnty);
							new_qnty      = rstock + old_qnty;

							temp_amount = rstock * pro_price;

							if(str_sub_total != '')temp_amount += tmp_sub_total;
							temp_amount = Math.round (temp_amount);
							total_2 = Math.round (temp_amount + vat);
							// new_stock     = cstock - new_qnty;
							new_price     = Math.round(price * new_qnty);

						}
					});
					if(product_specification==2)
					{
						$("#indi_pro_name").html('Serial setup for '+selected_producted);
						$("#show_product_individual_add_modal").modal('show');
						
						var submiturl = '<?php echo base_url();?>sale_controller/getIndiVidualProduct_warranty_new';
						var methods = 'POST';
						var output = '';
						var input_box='';
						$.ajax(
						{
							url: submiturl,
							type: methods,
							dataType: 'JSON',
							data: {'product_id':pro_id},  	
							success:function(result)
							{
								
								for(var ii=0; ii<result.length; ii++)
								{
									output+='<option value="'+result[ii].ip_id+'">'+result[ii].sl_no+'</option>';
								}
								for(var i=1; i<=qnty; i++)
								{
									input_box+='<div class="form-group"><label for="inputEmail3" class="col-sm-3 control-label">'+i+'. Serial No</label><div class="col-sm-9"><select class="form-control product_type select223" id="product_type" name="product_type"><option value="">Select Serial</option>'+output+'</select></div></div>';
								}
								$("#pro_serial_input").html(input_box);
							}
						});

						$('#add_product_serial_form').on('submit', function(service)
						{
							service.preventDefault();
							var submiturl = $(this).attr('action');
							var methods = $(this).attr('method');
							var data = $(this).serialize();
							var new_temp_sale_id = $("#new_temp_sale_id").val();
							$.ajax(
							{
								url: submiturl,
								type: methods,
								data: {'product_type': data,'product_id':pro_id,'new_temp_sale_id':new_temp_sale_id},  
								cache: false,		
								success:function(result)
								{
									var temp_data   = $("#temp_pro_data").val();
						
									num_of_tr += 1;

									var tmp_amount = rstock * pro_price;

									tmp_amount  = Math.round(tmp_amount);
									var total   = Math.round (tmp_amount + vat);
									$.ajax({
										url       : '<?php echo base_url()?>sale_controller/addProductToSale',
										type      : 'POST',
										cache     : false,
										data      : { temp_data: temp_data, pro_quantity: rstock, num_of_row: num_of_tr, total: total, pro_mrp_price: pro_mrp_price},
										success   :function(res)
										{
											$('#search_by_product_name').focus();
											location.reload();
										}
									});
								}
							});
						});
						
					}
					else
					{
						var temp_data   = $("#temp_pro_data").val();
						
						num_of_tr += 1;
						
		//                $('#selected_products td').each(function() {
		//                    alert(this.textContent);
		//                });
						var tmp_amount = rstock * pro_price;
							
						if(str_sub_total != '')tmp_amount += tmp_sub_total;
						
						tmp_amount  = Math.round(tmp_amount);
						var total   = Math.round (tmp_amount + vat);
						
						$('#sub_total').val(tmp_amount);
						$('#vat').val(vat);
						$('#total').val(total);
						$('#number_of_products').val();
						
						if(return_adjust != '' && !isNaN(return_adjust)){
							return_adjust = parseFloat(return_adjust);
							var pybl        = Math.round(total - return_adjust)
							if(pybl > 0)$('#payable').val(pybl);
							else $('#payable').val(0);
						}
						
						$.ajax({
							url       : '<?php echo base_url()?>sale_controller/addProductToSale',
							type      : "POST",
							cache     : false,
							data      : { temp_data: temp_data, pro_quantity: rstock, num_of_row: num_of_tr, total: total, mrp_price: mrp_price, pro_mrp_price: pro_mrp_price},
							success   :function(res){
								$("#selected_products").last().append(res);
								$('#search_by_product_name').val("");
								//$('#search_by_generic_name').val("");
							   // $('#search_by_barcode').val("");
								$('#search_by_product_name').focus();

								var in_words = convert_number_to_words(total);
								 
								$('#inword').val(in_words + " (TK)");
								$('#search_by_product_name').val("");
								$('#product_quantity').val("");
								$('#temp_pro_data').val("");
								$('#search_by_product_name').focus();
								location.reload();
							}
						});
					}         
				}         
			}      
    });

    $('#product_quantity').on('keyup', function(e)
	 {
        var stock           = $("#temp_pro_qty").val();         var cstock          = parseFloat(stock);
        var qnty            = $('#product_quantity').val();     var rstock          = parseFloat(qnty);

		var allow_negative_stock   = $('#allow_negative_stock').val();

        $('#product_quantity').css({'color': 'black'});
            
        if($.type(rstock) != 'number'){
            alert('Invalid Input');
            $('#product_quantity').val("");
        }
        else if(rstock > cstock && e.which != 8 && e.which != 13 && allow_negative_stock ==0)
		{
            $('#product_quantity').css({'color': 'red'});
            alert("Stock unavailable " + cstock);
            $('#search').val("");
            $('#product_quantity').val("");
            $('#search').focus();
            $('#product_quantity').css({'color': 'black'});
        }
		//location.reload();
           
    });

    /* End of product_quantity. */

    /* Start: Create Sale btn. */
    $('[name="sale_btn"]').on('click', function(){
          $('[name="sale_btn"]').attr("disabled", true);

          // $.ajax({
          //   url     : '<?php echo base_url()?>sale_controller/getUpdatedProducts',
          //   success : function(result){
          //     // updateAutocomplete(result);
          //     location.reload();
          //   }
          // });

        $.ajax({
            url     : '<?php echo base_url()?>sale_controller/addNewSale',
            type    : "POST",
            cache   : false,
            data    : { },
            success : function(result){
                location.reload();
                //$("#num_of_sale").last().append(result);
                //$('#search_by_product_name').focus();
                //$('[name="sale_btn"]').removeAttr("disabled");
            }

        });
    });
    
    /* End: Create Sale btn.*/

    /* Start: Cancel btn. */
    $('#cancel').on('click', function(){
        var is_sale_active   = $('#is_sale_active').val();
        
        if(is_sale_active)
        {    
            // var confirmation = confirm("Do you want to cancel the sale?");
                
            // if(confirmation){
            //     $('#sub_total').val("");
            //     $('#vat').val("");
            //     $('#disc_in_p').val("");
            //     $('#disc_in_f').val("");
            //     $('#disc_amount').val("");
            //     $('#total').val("");
            //     $('#received').val("");
            //     $('#change').val("");
            //     $('#number_of_products').val("");
            //     $('#select_customer').val("");
            //     $('#customer_name').val("");
            //     $('#customer_phone').val("");
            //     $("#selected_products").empty();
            //     $('#inword').val("");
            //     $.ajax({
            //         url: '<?php echo base_url()?>sale_controller/cancelSale',
            //         type: "POST",
            //         cache: false,
            //         data: { },
            //         success:function(result){
            //             location.reload();
            //             $('#search_by_product_name').focus();
            //         }

            //     });
            // }
            swal({
              title               : 'Are you sure?',
              text                : "You won't be able to revert this!",
              type                : 'warning',
              showCancelButton    : true,
              confirmButtonColor  : '#db8b0b',
              cancelButtonColor   : '#008d4c',
              confirmButtonText   : 'Yes',
              cancelButtonText    : 'No'
            }).then(function () {
                $('#sub_total').val("");
                $('#vat').val("");
                $('#disc_in_p').val("");
                $('#disc_in_f').val("");
                $('#disc_amount').val("");
                $('#total').val("");
                $('#received').val("");
                $('#change').val("");
                $('#number_of_products').val("");
                $('#select_customer').val("");
                $('#customer_name').val("");
                $('#customer_phone').val("");
                $("#selected_products").empty();
                $('#inword').val("");
                $('#return_adjust').val('');
                $('#payable').val('');
                $.ajax({
                    url: '<?php echo base_url()?>sale_controller/cancelSale',
                    type: "POST",
                    cache: false,
                    data: { },
                    success:function(result){
                      swal(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      )
                      location.reload();
                      $('#search_by_product_name').focus();
                    }

                });
            })
        }
        else{
            swal(
            'Oops...!',
            'Please select a sale!',
            'info'
          );
        }
    });
    /* End      : Cancel btn. */
    /* Start    : delete */
    $('#selected_product_list_tbl').on('click', '#delete', function(){
        //var thisTr          = $(this).closest('tr');
        //var value_added_tax = parseFloat($('#value_added_tax').val());

        swal({
            title               : 'Are you sure?',
            text                : "You won't be able to revert this!",
            type                : 'warning',
            showCancelButton    : true,
            confirmButtonColor  : '#db8b0b',
            cancelButtonColor   : '#419641',
            confirmButtonText   : 'Yes',
            cancelButtonText    : 'No'
        }).then(function () {
            //var tmp             = [];
            //var product_info    = thisTr.find('td:nth-child(7)').text().toString();
            //tmp                 = product_info.split("<>");
            var product_id      = parseInt($('#pro_duct_id').val());
            var product_qnty    = parseFloat($('#sale_stock_id').val());
			//alert(product_id);
			//alert(product_qnty);
            //var product_price   = parseFloat(tmp[2]);           
            //var sub_total       = parseFloat($('#sub_total').val());
            // var total           = parseFloat($('#total').val());
            //var num_of_pro      = parseFloat($('#number_of_products').val());
            // var disc_amount     = parseFloat($('#disc_amount').val());
            // var disc_in_p       = parseFloat($('#disc_in_p').val());
            // var disc_in_f       = parseFloat($('#disc_in_f').val());
                
           // var removed_product_price   = (product_qnty * product_price);
           // var new_sub_total           = sub_total - removed_product_price;
           // var new_VAT                 = ((new_sub_total * value_added_tax) / 100);
           // var new_total               = new_sub_total + new_VAT;
        
           // $('#disc_in_p').val("");
            //$('#disc_in_f').val("");
            //$('#disc_amount').val("");

           // new_sub_total                 = Math.round(new_sub_total);
            //new_VAT                       = Math.round(new_VAT);
            //new_total                     = Math.round(new_total);

            $.ajax({
                url     : '<?php echo base_url()?>sale_controller/removeProduct',
                type    : "POST",
                cache   : false,
                data    : { product_id: product_id, Quantity: product_qnty },
                success : function(result){
					//thisTr.remove();
                        
                    //if((num_of_pro - product_qnty) > 0){
                        //$('#sub_total').val(new_sub_total);
                        //$('#vat').val(new_VAT);
                       // $('#total').val(new_total);
                       // $('#number_of_products').val(num_of_pro - product_qnty);
                        //var in_words = convert_number_to_words(new_total);
                       // $('#inword').val(in_words + " (TK)");
                    //}

                   // else{
                       // $('#sub_total').val("");
                       // $('#vat').val("");
                       // $('#total').val("");
                        //$('#number_of_products').val("");
                        //$('#inword').val("");
                    //}

                    //$('#disc_in_p').val("");
                    //$('#disc_in_f').val("");
                    //$('#disc_amount').val("");
                    //$('#received').val("");
                    //$('#change').val("");
                   // $('#search_by_barcode').focus();
                    swal(
                      'Deleted!',
                      ':)',
                      'success'
                    )
					location.reload();
                    
                }

            });  
        })
    });
    /* End      : delete */
    /* Start      : edit */
	$('.edit_quantty').click(function(){
		
		var edit_id = $(this).attr('id');
		
		var kval = edit_id.substring(4, 10000000000);
		var quantity = $('#quantti_id'+kval).val();
		var stock = $('#stock_id'+kval).val();
		var sale = $('#sale_id'+kval).val();
		var buy = $('#buy_id'+kval).val();
		var temp_details_id = $('#temp_details_modal'+kval).val();
		var specification_id = $('#specification_id'+kval).val();
		var temp_sale_id = $('#new_temp_sale_id').val();
		var product_id = $('#pro_duct_idd'+kval).val();
		//alert(quantity+'//'+temp_details_id);
		$('#show_quantty_modal').modal('show');
		
		
		if(specification_id==2)
		{
			$('#quantityy').keyup(function()
			{
				var new_quantity = $(this).val();
				
				quantity = parseInt(new_quantity);
			
				$('.pro_serial_input_for_edit').show();
				$('.quantityy').val(quantity);
				$('.stockk').val(stock);
				$('.salee').val(sale);
				$('.buyy').val(buy);
				$('.temp_details_id').val(temp_details_id);
				$('.specification_details_id').val(specification_id);
				$('.temp_sale_id_details_id').val(temp_sale_id);
				$('.pro_details_id').val(product_id);
				
				var submiturl = '<?php echo base_url();?>sale_controller/getIndiVidualProduct_warranty';
				var methods = 'POST';
				var output = '';
				var output1 = new Array();
				var input_box='';
				var selected = '';
				var pro_name_serial='';
				var k=1;
				$.ajax(
				{
					url: submiturl,
					type: methods,
					dataType: 'JSON',
					data: {'product_id':product_id},  	
					success:function(result)
					{
						for(var i=0; i<quantity; i++)
						{
							output = '';
							for(var ii=0; ii<result['all_data'].length; ii++)
							{
								if (i < result['selected_data'].length) 
								{
									if(result['selected_data'][i].ip_id == result['all_data'][ii].ip_id)
									{
										selected = 'selected';
									}
									else
									{
										selected = '';
									}
								}
								else
								{
									selected = '';
								}
								output+='<option value="'+result['all_data'][ii].ip_id+'" '+selected+'>'+result['all_data'][ii].sl_no+'</option>';
							}
							input_box+='<div class="form-group"><label for="inputEmail3" class="col-sm-3 control-label">'+k+'. Serial No</label><div class="col-sm-9"><select class="form-control product_type select223" id="product_type" name="product_type[]" required="on"><option value="">Select Serial</option>'+output+'</select></div></div>';
							k++;
						}
						$(".pro_serial_input_for_edit_new").html(input_box);
					}
				});
			});
			
			$('.pro_serial_input_for_edit').show();
			$('.quantityy').val(quantity);
			$('.stockk').val(stock);
			$('.salee').val(sale);
			$('.buyy').val(buy);
			$('.temp_details_id').val(temp_details_id);
			$('.specification_details_id').val(specification_id);
			$('.temp_sale_id_details_id').val(temp_sale_id);
			$('.pro_details_id').val(product_id);
			
			var submiturl = '<?php echo base_url();?>sale_controller/getIndiVidualProduct_warranty';
			var methods = 'POST';
			var output = '';
			var output1 = new Array();
			var input_box='';
			var selected = '';
			var pro_name_serial='';
			var k=1;
			$.ajax(
			{
				url: submiturl,
				type: methods,
				dataType: 'JSON',
				data: {'product_id':product_id},  	
				success:function(result)
				{
					for(var i=0; i<quantity; i++)
					{
						output = '';
						for(var ii=0; ii<result['all_data'].length; ii++)
						{
							if (i < result['selected_data'].length) 
							{
								if(result['selected_data'][i].ip_id == result['all_data'][ii].ip_id)
								{
									selected = 'selected';
								}
								else
								{
									selected = '';
								}
							}
							else
							{
								selected = '';
							}
							output+='<option value="'+result['all_data'][ii].ip_id+'" '+selected+'>'+result['all_data'][ii].sl_no+'</option>';
						}
						input_box+='<div class="form-group"><label for="inputEmail3" class="col-sm-3 control-label">'+k+'. Serial No</label><div class="col-sm-9"><select class="form-control product_type select223" id="product_type" name="product_type[]" required="on"><option value="">Select Serial</option>'+output+'</select></div></div>';
						k++;
					}
					$(".pro_serial_input_for_edit_new").html(input_box);
				}
			});
		}
		else
		{
			$(".pre_pro_name_serialclass").hide();
			$('.pro_serial_input_for_edit').hide();
			$('.quantityy').val(quantity);
			$('.stockk').val(stock);
			$('.salee').val(sale);
			$('.buyy').val(buy);
			$('.temp_details_id').val(temp_details_id);
			$('.specification_details_id').val(specification_id);
			$('.temp_sale_id_details_id').val(temp_sale_id);
			$('.pro_details_id').val(kval);
		}
	});
	$('#change_quanttyy_form').on('submit', function(uxchomp)
	{
		uxchomp.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		
		$.ajax({
			url: submiturl,
			type: methods,
			data: $(this).serialize(),
			success:function(result){
				$('#show_quantty_modal').modal('hide');
				if(result == 'success'){
					swal(
                      'Saved!',
                      'Data Successfully Edited.)',
                      'success'
                    )
					 location.reload();
				}
				else{
					swal(
                      'Opss!',
                      'Data Successfully Not Edited.)',
                      'info'
                    )
					 location.reload();
				}
			 },
			error: function (jXHR, textStatus, errorThrown) {html("")}
		});
		
	}); 
    /* End    : Edit */
	$('#select_customer').on("change",function(evv)
	{
		evv.preventDefault();
		var customer_id 		= $(this).val();
		$('#selected_customer_id').val(customer_id);
	});
    /* Start    : Quick Sale */
	$('#received').on('keyup', function (efs)
	{      
		efs.defaultPrevented;
		if(efs.keyCode == 13) 
		{
			var received_amount = parseFloat($('#received').val());
			var total_amount = parseFloat($('#total').val());
			var customer = parseInt($('#selected_customer_id').val());
			var payable = parseFloat($('#payable').val());
			/* if(!isNaN(payable))
			{
				if(received_amount > payable && !isNaN(customer))
				{
					quick(efs);
				}
				else
				{
					alert('Select Customer.')
				}
			}
			else
			{
				if(received_amount > total_amount && !isNaN(customer))
				{
					quick(efs);
				}
				else
				{
					alert('Select Customer.')
				}
			} */
			if(received_amount < total_amount && isNaN(customer))
			{
				$('#received_alert').show();
				$('#received_alert').html('Received Amount Less Then Total Amount');
				alert('Select Customer.')
			}
			
			else if(received_amount < total_amount && !isNaN(customer))
			{
				quick(efs);
			}
			else if(received_amount >= total_amount)
			{
				quick(efs);
			}
			
		}
		else
		{
			$('#received_alert').hide();
			$('#received').focus();
		}
	});

    $('#quick_sale').on('click', function(e)
	{
		quick(e);
	});

    function quick(e)
	{
		//e.defaultPrevented;
        var is_sale_active   = $('#is_sale_active').val();

        if(!is_sale_active)
		{
            swal(
              'Oops...!',
              'Please select a sale!',
              'info'
            );
        }
        else
        {
            swal({
              title               : 'Are You Sure About Sale?',
              text                : "You won't be able to revert this!",
              type                : 'warning',
              showCancelButton    : true,
              confirmButtonColor  : '#db8b0b',
              cancelButtonColor   : '#008d4c',
              confirmButtonText   : 'Yes',
              cancelButtonText    : 'No'
            }).then(function() 
			{
				var sub_total       = parseFloat($('#sub_total').val());
				var vat             = parseFloat($('#vat').val());
				var total           = parseFloat($('#total').val());
				var received        = parseFloat($('#received').val());
				var customer_id     = $('#selected_customer_id').val();
				var disc_in_p       = parseFloat($('#disc_in_p').val());
				var disc_in_f       = parseFloat($('#disc_in_f').val());
				var disc_amount     = parseFloat($('#disc_amount').val());
				var delivery_charge = parseFloat($('#delivery_charge').val());
				var customer_name   = $('#customer_name').val();
				var customer_phn    = $('#customer_phone').val();
				var return_adjust   = parseFloat($('#return_adjust').val());
				var change          = parseFloat($('#change').val());
				var payable         = parseFloat($('#payable').val());
				var return_id       = $('#hid_return_id').val();
				var discount_limit  = $('#discount_limit').val();
				
				if(disc_amount > total && discount_limit==0)
				{
					swal(
						'Oops...!',
						'Discount Amount is Greater Than Total Amount!',
						'warning'
					  );
				}
				else
				{
					if(sub_total != '' && total != '')
					{
						$.ajax({
							url: '<?php echo base_url()?>sale_controller/doSale',
							type: "POST",
							cache: false,
							async: false,
							data: { 
								sub_total       : sub_total, 
								total_          : total, 
								customer_id     : customer_id, 
								disc_in_p       : disc_in_p, 
								disc_in_f       : disc_in_f,
								disc_amount     : disc_amount,
								received        : received,
								delivery_charge : delivery_charge,
								change          : change,
								customer_name   : customer_name,
								customer_phn    : customer_phn,
								return_adjust   : return_adjust,
								payable   		: payable,
								return_id   	: return_id,
								flg             : 1             /// for quick sale it is 1.
							},
							success:function(result)
							{
								//alert(result);
								$('#sub_total').val("");
								$('#vat').val("");
								$('#disc_in_p').val("");
								$('#disc_in_f').val("");
								$('#disc_amount').val("");
								$('#total').val("");
								$('#received').val("");
								$('#delivery_charge').val("");
								$('#change').val("");
								$('#number_of_products').val("");
								$('#select_customer').val("");
								$('#customer_name').val("");
								$('#customer_phone').val("");
								$('#inword').val("");
								$('#return_id').val("");
								$("#selected_products").empty();
								$("#sale_return_list").empty();
								
								location.reload(); 
								$('#search_by_product_name').focus();
								window.open("<?php echo base_url()?>New_invoice_print/index/" + result, '_blank');          
							}  
						});
							
					}
				
					else 
					{
					  swal(
						'Oops...!',
						'Data Missing!',
						'warning'
					  );
					}
				}
			})
        }
    }
    /* End      : Quick Sale */
	/* Start    : Credit Sale */
    $('#credit_sale').on('click', function(e){
        if (e.originalEvent.defaultPrevented) return;
        
        var is_sale_active   = $('#is_sale_active').val();

        if(!is_sale_active){
            swal(
              'Oops...!',
              'Please select a sale!',
              'info'
            );
        }
        else
        {
            swal({
              title               : 'Are You Sure About Credit Sale?',
              text                : "You won't be able to revert this!",
              type                : 'warning',
              showCancelButton    : true,
              confirmButtonColor  : '#db8b0b',
              cancelButtonColor   : '#008d4c',
              confirmButtonText   : 'Yes',
              cancelButtonText    : 'No'
            }).then(function () {
				var sub_total       = $('#sub_total').val();
				var vat             = $('#vat').val();
				var total           = parseFloat($('#total').val());
				var received        = $('#received').val();
				var customer_id     = $('#selected_customer_id').val();
				var disc_in_p       = $('#disc_in_p').val();
				var disc_in_f       = $('#disc_in_f').val();
				var disc_amount     = parseFloat($('#disc_amount').val());
				var delivery_charge     = parseFloat($('#delivery_charge').val());
				var customer_name   = $('#customer_name').val();
				var customer_phn    = $('#customer_phone').val();
				var return_adjust   = $('#return_adjust').val();
				var change          = $('#change').val();
				var payable          = $('#payable').val();
				var return_id          = $('#hid_return_id').val();
				if(disc_amount > total)
				{
					swal(
						'Oops...!',
						'Discount Amount is Greater Than Total Amount!',
						'warning'
					  );
				}
				else
				{
					if(sub_total != '' && total != '' && customer_id!='')
					{
						$.ajax({
							url: '<?php echo base_url()?>sale_controller/doSale_credit',
							type: "POST",
							cache: false,
							async: false,
							data: { 
								sub_total       : sub_total, 
								total_          : total, 
								customer_id     : customer_id, 
								disc_in_p       : disc_in_p, 
								disc_in_f       : disc_in_f,
								disc_amount     : disc_amount,
								received        : received,
								delivery_charge        : delivery_charge,
								change          : change,
								customer_name   : customer_name,
								customer_phn    : customer_phn,
								return_adjust   : return_adjust,
								payable   		: payable,
								return_id   	: return_id,
								flg             : 1             /// for quick sale it is 1.
							},
							success:function(result)
							{
								$('#sub_total').val("");
								$('#vat').val("");
								$('#disc_in_p').val("");
								$('#disc_in_f').val("");
								$('#disc_amount').val("");
								$('#total').val("");
								$('#received').val("");
								$('#delivery_charge').val("");
								$('#change').val("");
								$('#number_of_products').val("");
								$('#select_customer').val("");
								$('#customer_name').val("");
								$('#customer_phone').val("");
								$('#inword').val("");
								$('#return_id').val("");
								$("#selected_products").empty();
								$("#sale_return_list").empty();
								
								location.reload(); 
								$('#search_by_product_name').focus();
								window.open("<?php echo base_url()?>New_invoice_print/index/" + result, '_blank');          
							}  
						});
							
					}
				
					else {
					  swal(
						'Oops...!',
						'Data Missing!',
						'warning'
					  );
					}
				}
			})
        }
    });
    /* End      : Credit Sale */
	/* Start    : Master Card */
    $('#master_id').on('click', function(e){
		if (e.originalEvent.defaultPrevented) return;
        
        var is_sale_active   = $('#is_sale_active').val();

        if(!is_sale_active){
            swal(
              'Oops...!',
              'Please select a sale!',
              'info'
            );
        }
        else
        {
			swal({
              title               : 'Are You Sure About <img src="<?php echo base_url();?>assets/assets2/dist/img/credit/mastercard.png" alt="Mastercard"> Sale?',
              text                : "You won't be able to revert this!",
              type                : 'warning',
              showCancelButton    : true,
              confirmButtonColor  : '#db8b0b',
              cancelButtonColor   : '#008d4c',
              confirmButtonText   : 'Yes',
              cancelButtonText    : 'No'
            }).then(function () {
				var bank_id       	= $('#bank_id').val();
				var card_id       	= $('#master_id').val();
				var sub_total       = $('#sub_total').val();
				var vat             = $('#vat').val();
				var total           = $('#total').val();
				var received        = $('#received').val();
				var delivery_charge        = $('#delivery_charge').val();
				var customer_id     = $('#selected_customer_id').val();
				var disc_in_p       = $('#disc_in_p').val();
				var disc_in_f       = $('#disc_in_f').val();
				var disc_amount     = $('#disc_amount').val();
				var customer_name   = $('#customer_name').val();
				var customer_phn    = $('#customer_phone').val();
				var return_adjust   = $('#return_adjust').val();
				var change          = $('#change').val();
				var payable         = $('#payable').val();
				var return_id       = $('#hid_return_id').val();
			  
				if(return_adjust !='')
				{
					if(received != payable)
					{
						alert('Your Paid Amount is smaller then Payble.');
					}
					else if(received == payable && isNaN(customer_id))
					{
						alert('Please Select Customer');
					}
					else if(isNaN(received) && isNaN(customer_id))
					{
						alert('Please Select Paid Amount & Customer');
					}
					
					else
					{
						$.ajax({
							url: '<?php echo base_url()?>sale_controller/doSale_card',
							type: "POST",
							cache: false,
							async: false,
							data: { 
								sub_total       : sub_total, 
								total_          : total, 
								customer_id     : customer_id, 
								disc_in_p       : disc_in_p, 
								disc_in_f       : disc_in_f,
								disc_amount     : disc_amount,
								received        : received,
								delivery_charge        : delivery_charge,
								change          : change,
								customer_name   : customer_name,
								customer_phn    : customer_phn,
								return_adjust   : return_adjust,
								card_id   		: card_id,
								bank_id   		: bank_id,
								payable   		: payable,
								return_id   	: return_id,
								flg             : 1             /// for quick sale it is 1.
							},
							success:function(result)
							{
								//alert(result);
								$('#sub_total').val("");
								$('#vat').val("");
								$('#disc_in_p').val("");
								$('#disc_in_f').val("");
								$('#disc_amount').val("");
								$('#total').val("");
								$('#received').val("");
								$('#delivery_charge').val("");
								$('#change').val("");
								$('#number_of_products').val("");
								$('#select_customer').val("");
								$('#customer_name').val("");
								$('#customer_phone').val("");
								$('#inword').val("");
								$('#return_id').val("");
								$("#selected_products").empty();
								$("#sale_return_list").empty();
								var card_id2 = $('#master_id').val();
								location.reload(); 
								$('#search_by_product_name').focus();
								window.open("<?php echo base_url();?>New_invoice_print/index/" + result+'/'+ card_id2, '_blank');          
							}  
						});
						
					}
				}
				else if(received !='' && sub_total != '' && total != '')
				{
						$.ajax({
							url: '<?php echo base_url()?>sale_controller/doSale_card',
							type: "POST",
							cache: false,
							async: false,
							data: { 
								sub_total       : sub_total, 
								total_          : total, 
								customer_id     : customer_id, 
								disc_in_p       : disc_in_p, 
								disc_in_f       : disc_in_f,
								disc_amount     : disc_amount,
								received        : received,
								delivery_charge        : delivery_charge,
								change          : change,
								customer_name   : customer_name,
								customer_phn    : customer_phn,
								return_adjust   : return_adjust,
								card_id   		: card_id,
								bank_id   		: bank_id,
								payable   		: payable,
								return_id   	: return_id,
								flg             : 1             /// for quick sale it is 1.
							},
							success:function(result){
								$('#sub_total').val("");
								$('#vat').val("");
								$('#disc_in_p').val("");
								$('#disc_in_f').val("");
								$('#disc_amount').val("");
								$('#total').val("");
								$('#received').val("");
								$('#delivery_charge').val("");
								$('#change').val("");
								$('#number_of_products').val("");
								$('#select_customer').val("");
								$('#customer_name').val("");
								$('#customer_phone').val("");
								$('#inword').val("");
								$('#return_id').val("");
								$("#selected_products").empty();
								$("#sale_return_list").empty();
								var card_id2 = $('#master_id').val();
								location.reload(); 
								$('#search_by_product_name').focus();
								window.open("<?php echo base_url();?>New_invoice_print/index/" + result+'/'+ card_id2, '_blank');          
							}  
						});
				}
				else {
				  swal(
					'Oops...!',
					'Data Missing!',
					'warning'
				  );
				}
			})
        }
    });
    /* End      : Master Card Sale */
	/* Start    : Visa Card */
    $('#visa_id').on('click', function(e){

		if (e.originalEvent.defaultPrevented) return;
        
        var is_sale_active   = $('#is_sale_active').val();

        if(!is_sale_active){
            swal(
              'Oops...!',
              'Please select a sale!',
              'info'
            );
        }
        else
        {
            swal({
              title               : 'Are You Sure About <img src="<?php echo base_url();?>assets/assets2/dist/img/credit/visa.png" alt="Visa Card"> Sale?',
              text                : "You won't be able to revert this!",
              type                : 'warning',
              showCancelButton    : true,
              confirmButtonColor  : '#db8b0b',
              cancelButtonColor   : '#008d4c',
              confirmButtonText   : 'Yes',
              cancelButtonText    : 'No'
            }).then(function () {
				var bank_id       	= $('#bank_id').val();
				var card_id       	= $('#master_id').val();
				var sub_total       = $('#sub_total').val();
				var vat             = $('#vat').val();
				var total           = $('#total').val();
				var received        = $('#received').val();
				var delivery_charge        = $('#delivery_charge').val();
				var customer_id     = $('#selected_customer_id').val();
				var disc_in_p       = $('#disc_in_p').val();
				var disc_in_f       = $('#disc_in_f').val();
				var disc_amount     = $('#disc_amount').val();
				var customer_name   = $('#customer_name').val();
				var customer_phn    = $('#customer_phone').val();
				var return_adjust   = $('#return_adjust').val();
				var change          = $('#change').val();
				var payable         = $('#payable').val();
				var return_id       = $('#hid_return_id').val();
			  
				if(return_adjust !='')
				{
					if(received != payable)
					{
						alert('Your Paid Amount is smaller then Payble.');
					}
					else if(received == payable && isNaN(customer_id))
					{
						alert('Please Select Customer');
					}
					else if(isNaN(received) && isNaN(customer_id))
					{
						alert('Please Select Paid Amount & Customer');
					}
					
					else
					{
						$.ajax({
							url: '<?php echo base_url()?>sale_controller/doSale_card',
							type: "POST",
							cache: false,
							async: false,
							data: { 
								sub_total       : sub_total, 
								total_          : total, 
								customer_id     : customer_id, 
								disc_in_p       : disc_in_p, 
								disc_in_f       : disc_in_f,
								disc_amount     : disc_amount,
								received        : received,
								delivery_charge        : delivery_charge,
								change          : change,
								customer_name   : customer_name,
								customer_phn    : customer_phn,
								return_adjust   : return_adjust,
								card_id   		: card_id,
								bank_id   		: bank_id,
								payable   		: payable,
								return_id   	: return_id,
								flg             : 1             /// for quick sale it is 1.
							},
							success:function(result)
							{
								alert(result);
								$('#sub_total').val("");
								$('#vat').val("");
								$('#disc_in_p').val("");
								$('#disc_in_f').val("");
								$('#disc_amount').val("");
								$('#total').val("");
								$('#received').val("");
								$('#delivery_charge').val("");
								$('#change').val("");
								$('#number_of_products').val("");
								$('#select_customer').val("");
								$('#customer_name').val("");
								$('#customer_phone').val("");
								$('#inword').val("");
								$('#return_id').val("");
								$("#selected_products").empty();
								$("#sale_return_list").empty();
								var card_id2 = $('#master_id').val();
								location.reload(); 
								$('#search_by_product_name').focus();
								window.open("<?php echo base_url();?>New_invoice_print/index/" + result+'/'+ card_id2, '_blank');          
							}  
						});
						
					}
				}
				else if(received !='' && sub_total != '' && total != '')
				{
						$.ajax({
							url: '<?php echo base_url()?>sale_controller/doSale_card',
							type: "POST",
							cache: false,
							async: false,
							data: { 
								sub_total       : sub_total, 
								total_          : total, 
								customer_id     : customer_id, 
								disc_in_p       : disc_in_p, 
								disc_in_f       : disc_in_f,
								disc_amount     : disc_amount,
								received        : received,
								delivery_charge        : delivery_charge,
								change          : change,
								customer_name   : customer_name,
								customer_phn    : customer_phn,
								return_adjust   : return_adjust,
								card_id   		: card_id,
								bank_id   		: bank_id,
								payable   		: payable,
								return_id   	: return_id,
								flg             : 1             /// for quick sale it is 1.
							},
							success:function(result){
								$('#sub_total').val("");
								$('#vat').val("");
								$('#disc_in_p').val("");
								$('#disc_in_f').val("");
								$('#disc_amount').val("");
								$('#total').val("");
								$('#received').val("");
								$('#delivery_charge').val("");
								$('#change').val("");
								$('#number_of_products').val("");
								$('#select_customer').val("");
								$('#customer_name').val("");
								$('#customer_phone').val("");
								$('#inword').val("");
								$('#return_id').val("");
								$("#selected_products").empty();
								$("#sale_return_list").empty();
								var card_id2 = $('#master_id').val();
								location.reload(); 
								$('#search_by_product_name').focus();
								window.open("<?php echo base_url();?>New_invoice_print/index/" + result+'/'+ card_id2, '_blank');          
							}  
						});
				}
				else {
				  swal(
					'Oops...!',
					'Data Missing!',
					'warning'
				  );
				}
			})
        }
    });
    /* End      : Visa Card Sale */
	/* Start    : American Express */
    $('#american_express_id').on('click', function(e){

		if (e.originalEvent.defaultPrevented) return;
        
        var is_sale_active   = $('#is_sale_active').val();

        if(!is_sale_active){
            swal(
              'Oops...!',
              'Please select a sale!',
              'info'
            );
        }
        else
        {
            swal({
              title               : 'Are You Sure About <img src="<?php echo base_url();?>assets/assets2/dist/img/credit/american-express.png" alt="American Express Card"> Sale?',
              text                : "You won't be able to revert this!",
              type                : 'warning',
              showCancelButton    : true,
              confirmButtonColor  : '#db8b0b',
              cancelButtonColor   : '#008d4c',
              confirmButtonText   : 'Yes',
              cancelButtonText    : 'No'
            }).then(function () {
				var bank_id       	= $('#bank_id').val();
				var card_id       	= $('#master_id').val();
				var sub_total       = $('#sub_total').val();
				var vat             = $('#vat').val();
				var total           = $('#total').val();
				var received        = $('#received').val();
				var delivery_charge        = $('#delivery_charge').val();
				var customer_id     = $('#selected_customer_id').val();
				var disc_in_p       = $('#disc_in_p').val();
				var disc_in_f       = $('#disc_in_f').val();
				var disc_amount     = $('#disc_amount').val();
				var customer_name   = $('#customer_name').val();
				var customer_phn    = $('#customer_phone').val();
				var return_adjust   = $('#return_adjust').val();
				var change          = $('#change').val();
				var payable         = $('#payable').val();
				var return_id       = $('#hid_return_id').val();
			  
				if(return_adjust !='')
				{
					if(received != payable)
					{
						alert('Your Paid Amount is smaller then Payble.');
					}
					else if(received == payable && isNaN(customer_id))
					{
						alert('Please Select Customer');
					}
					else if(isNaN(received) && isNaN(customer_id))
					{
						alert('Please Select Paid Amount & Customer');
					}
					
					else
					{
						$.ajax({
							url: '<?php echo base_url()?>sale_controller/doSale_card',
							type: "POST",
							cache: false,
							async: false,
							data: { 
								sub_total       : sub_total, 
								total_          : total, 
								customer_id     : customer_id, 
								disc_in_p       : disc_in_p, 
								disc_in_f       : disc_in_f,
								disc_amount     : disc_amount,
								received        : received,
								delivery_charge        : delivery_charge,
								change          : change,
								customer_name   : customer_name,
								customer_phn    : customer_phn,
								return_adjust   : return_adjust,
								card_id   		: card_id,
								bank_id   		: bank_id,
								payable   		: payable,
								return_id   	: return_id,
								flg             : 1             /// for quick sale it is 1.
							},
							success:function(result)
							{
								alert(result);
								$('#sub_total').val("");
								$('#vat').val("");
								$('#disc_in_p').val("");
								$('#disc_in_f').val("");
								$('#disc_amount').val("");
								$('#total').val("");
								$('#received').val("");
								$('#delivery_charge').val("");
								$('#change').val("");
								$('#number_of_products').val("");
								$('#select_customer').val("");
								$('#customer_name').val("");
								$('#customer_phone').val("");
								$('#inword').val("");
								$('#return_id').val("");
								$("#selected_products").empty();
								$("#sale_return_list").empty();
								var card_id2 = $('#master_id').val();
								location.reload(); 
								$('#search_by_product_name').focus();
								window.open("<?php echo base_url();?>New_invoice_print/index/" + result+'/'+ card_id2, '_blank');          
							}  
						});
						
					}
				}
				else if(received !='' && sub_total != '' && total != '')
				{
						$.ajax({
							url: '<?php echo base_url()?>sale_controller/doSale_card',
							type: "POST",
							cache: false,
							async: false,
							data: { 
								sub_total       : sub_total, 
								total_          : total, 
								customer_id     : customer_id, 
								disc_in_p       : disc_in_p, 
								disc_in_f       : disc_in_f,
								disc_amount     : disc_amount,
								received        : received,
								delivery_charge        : delivery_charge,
								change          : change,
								customer_name   : customer_name,
								customer_phn    : customer_phn,
								return_adjust   : return_adjust,
								card_id   		: card_id,
								bank_id   		: bank_id,
								payable   		: payable,
								return_id   	: return_id,
								flg             : 1             /// for quick sale it is 1.
							},
							success:function(result){
								$('#sub_total').val("");
								$('#vat').val("");
								$('#disc_in_p').val("");
								$('#disc_in_f').val("");
								$('#disc_amount').val("");
								$('#total').val("");
								$('#received').val("");
								$('#delivery_charge').val("");
								$('#change').val("");
								$('#number_of_products').val("");
								$('#select_customer').val("");
								$('#customer_name').val("");
								$('#customer_phone').val("");
								$('#inword').val("");
								$('#return_id').val("");
								$("#selected_products").empty();
								$("#sale_return_list").empty();
								var card_id2 = $('#master_id').val();
								location.reload(); 
								$('#search_by_product_name').focus();
								window.open("<?php echo base_url();?>New_invoice_print/index/" + result+'/'+ card_id2, '_blank');          
							}  
						});
				}
				else {
				  swal(
					'Oops...!',
					'Data Missing!',
					'warning'
				  );
				}
			})
        }
    });
    /* End      : American Express */
    /* Start    : customer_phone */
    $('#customer_phone').on('keydown', function(e){
            
        if(e.keyCode === 13)
        {
            var sub_total       = $('#sub_total').val();
            var vat             = $('#vat').val();
            var total           = $('#total').val();
            var received        = $('#received').val();
            var customer_id     = $('#selected_customer_id').val();
            var disc_in_p       = $('#disc_in_p').val();
            var disc_in_f       = $('#disc_in_f').val();
            var disc_amount     = $('#disc_amount').val();
            var change          = $('#change').val();
            var customer_name   = $('#customer_name').val();
            var customer_phn    = $('#customer_phone').val();
            var success         = false;

            if(customer_name == '' || customer_phn == '' || sub_total == '' || total == '' || received == ''){
               alert('Data Missing');
            }
            else if(customer_phn.length != 11 && !isNaN(customer_phn)){
                  alert('Invalid Phone number!');
            }
            else{
                $.ajax({
                    url     : '<?php echo base_url()?>sale_controller/doSale',
                    type    : "POST",
                    cache   : false,
                    async   : false,
                    data    : { 
                        sub_total       : sub_total, 
                        total_          : total, 
                        customer_id     : customer_id, 
                        disc_in_p       : disc_in_p, 
                        disc_in_f       : disc_in_f,
                        disc_amount     : disc_amount,
                        received        : received,
                        change          : change,
                        customer_name   : customer_name,
                        customer_phn    : customer_phn,
                        flg             : 0             /// for quick sale it is 1.
                    },
                    success:function(result){   
                        $('#sub_total').val("");
                        $('#vat').val("");
                        $('#disc_in_p').val("");
                        $('#disc_in_f').val("");
                        $('#disc_amount').val("");
                        $('#total').val("");
                        $('#received').val("");
                        $('#change').val("");
                        $('#number_of_products').val("");
                        $('#select_customer').val("");
                        $('#customer_name').val("");
                        $('#customer_phone').val("");
                        $('#inword').val("");
                        $("#selected_products").empty();
                        $("#sale_return_list").empty();

                        location.reload();
                        $('#search_by_product_name').focus();
                        window.open("<?php echo base_url();?>New_invoice_print/index" + result, '_blank');
                    }  
                });
            }
        }
    });
    /* End      : customer_phone*/
    /* Start    : Key event. */
    $(document).on('keydown', function(e)
	{
        if(e.keyCode === 113)
		{              ///F2
            var received    = $('#received').is(':focus');
            var disc_p      = $('#disc_in_p').is(':focus');
            var disc_f      = $('#disc_in_f').is(':focus');
            var payment      = $('#payment').is(':focus');

            if(disc_p){
                $('#disc_in_f').focus();
            }
            else if(disc_f){
                $('#payment').focus();
            }
			else if(payment){
                $('#received').focus();
            }
            else if(received){
                $('#disc_in_p').focus();
            }
            else
			{
                $('#disc_in_p').focus();
            }   
        }
            
        else if(e.keyCode === 115 )
		{
                
            var customer_name       = $('#customer_name').is(':focus');
            var select_customer     = $('#select_customer').is(':focus');
                
            if(select_customer){
                $('#customer_name').focus();
            }
            else if(customer_name){
                $('#select_customer').focus();
            }
            else{
                $('#select_customer').focus();
            }
        }
            
    });

    /* Start: Discount in %. */
    $("#disc_in_p").on('keyup', function(e){
        var str_disc      = $(this).val();   
        var disc_val      = parseFloat(str_disc);
        var return_adjust = $('#return_adjust').val();
        var tmp_re_ad     = 0;
        var payable       = 0;

        if(str_disc != "" && !isNaN(disc_val) && disc_val > 0){
            var str_sub_total   = $('#sub_total').val();        var sub_total   = parseFloat(str_sub_total);
            var str_vat         = $('#vat').val();              var vat         = parseFloat(str_vat);
            var disc_amount     = disc_val * sub_total / 100;
                
            $('#disc_in_f').val("");
                
            $('#disc_amount').val(Math.round(disc_amount));
                
            if(return_adjust != '')var tmp_re_ad   = parseFloat(return_adjust);
            var payable = Math.round(((sub_total - disc_amount) + vat)-tmp_re_ad);
            var total   = Math.round(((sub_total - disc_amount) + vat));
                
            if(!isNaN(total)){
                $('#total').val(total);
                if(return_adjust != '')$('#payable').val(payable);
                var txt = convert_number_to_words(total) + " (TK)";
                $('#inword').val(txt);
            }
            $('#received').val("");
            $('#change').val("");
        }
        else if(str_disc == "" && e.keyCode != 113 ){
            $('#disc_amount').val("");
            var str_sub_total   = $('#sub_total').val();        var sub_total   = parseFloat(str_sub_total);
            var str_vat         = $('#vat').val();              var vat         = parseFloat(str_vat);
                
            if(return_adjust != '')var tmp_re_ad   = parseFloat(return_adjust);
            var payable         = Math.round((sub_total + vat)-tmp_re_ad);
            var total           = Math.round((sub_total + vat));

            if(!isNaN(total)){
                $('#total').val(total);
                if(return_adjust != '')$('#payable').val(payable);
                var txt = convert_number_to_words(total) + " (TK)";
                $('#inword').val(txt);
            }
            $('#received').val("");
            $('#change').val("");
        }
    });
    /* End      : Discount in %. */
    /* Start    : Discount in TK. */ 
    $("#disc_in_f").on('keyup', function(){
            var str_disc_f    = $(this).val();   
            var disc_val      = parseFloat(str_disc_f);
            var str_disc_p    = $('#disc_in_p').val();
            var return_adjust = $('#return_adjust').val();
            var tmp_re_ad     = 0;
            var payable       = 0;

            if(str_disc_f != '' && !isNaN(disc_val) && disc_val > 0){
                var str_sub_total   = $('#sub_total').val();        var sub_total   = parseFloat(str_sub_total);
                var str_vat         = $('#vat').val();              var vat         = parseFloat(str_vat);
                
                if(return_adjust != '')var tmp_re_ad   = parseFloat(return_adjust);

                $('#disc_in_p').val("");
                $('#disc_amount').val(disc_val);
                var total   = (sub_total - disc_val) + vat;
                
                if(!isNaN(total)){
                    payable   = Math.round(total - tmp_re_ad);
                    $('#total').val(total);
                    if(return_adjust != '')$('#payable').val(payable);

                    var txt = convert_number_to_words(total) + " (TK)";
                    $('#inword').val(txt);
                }
                $('#received').val("");
                $('#change').val("");
            }
            else if(str_disc_f == '' && str_disc_p == '')
			{
                $('#disc_amount').val("");
                var str_sub_total   = $('#sub_total').val();        var sub_total   = parseFloat(str_sub_total);
                var str_vat         = $('#vat').val();              var vat         = parseFloat(str_vat);
                
                if(return_adjust != '')var tmp_re_ad   = parseFloat(return_adjust);
                total         = Math.round(sub_total + vat);
                var payable   = total - tmp_re_ad;
                
                if(!isNaN(total)){
                    payable       = Math.round(payable);
                    $('#total').val(total);
                    if(return_adjust != '')$('#payable').val(payable);

                    var txt = convert_number_to_words(total) + " (TK)";
                    $('#inword').val(txt);
                }
                // $('#received').val("");
                // $('#change').val("");
            }
            
    });
    /* End  : Discount in TK. */
    $('#received').on('keyup', function()
	{
        var str_received    = $('#received').val();     var int_received  = parseFloat(str_received);
        var str_total       = $('#total').val();        var int_total     = parseFloat(str_total);
        var str_payable     = $('#payable').val();      var payable       = parseFloat(str_payable);
        var str_payment     = $('#payment').val();      var payment       = parseFloat(str_payment);

       if(str_payable != '' && !isNaN(str_payable))
		{
          if(str_received != '' && str_total != '' && !isNaN(str_received) && int_received > 0)
		  {
              $('#change').val(Math.round(int_received - payable));
          }
          if(str_received == '')$('#change').val("");
        }
		
        else
		{
          if(str_received != '' && str_total != '' && !isNaN(str_received) && int_received > 0)
		  {
              $('#change').val(Math.round(int_received - int_total));
          }
          if(str_received == '')$('#change').val("");
        }
    });

    function getSaleId(id){
        
	var kval = id.substring(8, 1000);
       $.ajax({
          url     : '<?php echo base_url()?>sale_controller/setCurrentSale',
          type    : "POST",
          data    : {id: kval},
          success : function(result){
            location.reload();
            $('#selected_products').html(result);

            var QNTY        = $('#hid_qty').val();
            var sub_total   = $('#hid_sub_to').val();
            var VAT         = $('#hid_vat').val();

            $('#search_by_barcode').focus();
          }
        });

       }
    function do_calculation(product_price)
    {
        alert(product_price);
    }

    function convert_number_to_words(number){

            var hyphen        = '-';
            var conjunction   = ' AND ';
            var separator     = ', ';
            var negative      = 'NEGATIVE ';
            var decimal       = ' POINT ';

            var dictionary    = [];

            dictionary[0]     = 'ZERO';
            dictionary[1]     = 'ONE';
            dictionary[2]     = 'TWO';
            dictionary[3]     = 'THREE';
            dictionary[4]     = 'FOUR';
            dictionary[5]     = 'FIVE';
            dictionary[6]     = 'SIX';
            dictionary[7]     = 'SEVEN';
            dictionary[8]     = 'EIGHT';
            dictionary[9]     = 'NINE';
            dictionary[10]    = 'TEN';
            dictionary[11]    = 'ELEVEN';
            dictionary[12]    = 'TWELVE';
            dictionary[13]    = 'THIRTEEN';
            dictionary[14]    = 'FOURTEEN';
            dictionary[15]    = 'FIFTEEN';
            dictionary[16]    = 'SIXTEEN';
            dictionary[17]    = 'SEVENTEEN';
            dictionary[18]    = 'EIGHTEEN';
            dictionary[19]    = 'NINETEEN';
            dictionary[20]    = 'TWENTY';
            dictionary[30]    = 'THIRTY';
            dictionary[40]    = 'FOURTY';
            dictionary[50]    = 'FIFTY';
            dictionary[60]    = 'SIXTY';
            dictionary[70]    = 'SEVENTY';
            dictionary[80]    = 'EIGHTY';
            dictionary[90]    = 'NINETY';
            dictionary[100]   = 'HUNDRED';
            dictionary[1000]      = 'THOUSAND';
            dictionary[1000000]     = 'MILLION';
            dictionary[1000000000]    = 'BILLION';
            dictionary[1000000000000]   = 'TRILLION';
            dictionary[1000000000000000]  = 'QUADRILLION';
            dictionary[1000000000000000000] = 'QUINTILLION';

            if(isNaN(number)){
                    return false;
            }
            if(number < 0){
                    return negative + convert_number_to_words(Math.abs(number));
            }

            var string = ""; var fraction = "";

            if (number.toString().indexOf('.')) {
                var tmp     = [];
                tmp         = number.toString().split(".");
                number      = tmp[0];
                fraction    = tmp[1];
            }

            switch(true){
                case number < 21:
                string = dictionary[number];
                break;

                case number < 100:
                    var tens    = parseInt((number / 10)) * 10;
                    var units   = number % 10;
                    string  = dictionary[tens];
                    if (units) {
                        string += hyphen + dictionary[units];
                    }
                    break;

                case number < 1000:
                    var hundreds  = parseInt(number / 100);
                    var remainder = (number % 100);
                    string = dictionary[hundreds] + ' ' + dictionary[100];
                    if (remainder) {
                        string += conjunction + convert_number_to_words(remainder);
                    }
                    break;

                default:
                    var tmp         = Math.log(number) / Math.log(1000);
                    var baseUnit    = Math.pow(1000, Math.floor(tmp));

                var numBaseUnits    = parseInt(number / baseUnit);
                var remainder       = parseInt(number % baseUnit);
                string              = convert_number_to_words(numBaseUnits) + ' ' + dictionary[baseUnit];
                if (remainder) {
                    string += remainder < 100 ? conjunction : separator;
                    string += convert_number_to_words(remainder);
                }
                break;
            }

            if("" != fraction && !isNaN(fraction)){
                string  += decimal;
                $.each(fraction.toString().split(""), function(key, number) {
                    string += dictionary[number] + ' ';
                });
            }
            return string;

  }
  /*Start: Quotation. */
  $('#quotation').on('click', function(event){
    event.preventDefault();

    var number_of_product   = $('#number_of_products').val();
    var id                  = $('#is_sale_active').val();

    if(id == ''){
      swal(
        'Oops...!',
        'Please select a sale!',
        'info'
      );
    }
    else{
      if(number_of_product != ''){

        $.ajax({
          url     : '<?php echo base_url()?>sale_controller/doQuotation',
          type    : "POST",
          data    : {number_of_product   : number_of_product},
          success : function(result){
            window.open("<?php echo base_url()?>sale_controller/printQuotation/" + result);
            location.reload();
          }

        });
      }
      else{
        swal(
          'Oops...!',
          'Please select product(s)!',
          'info'
        );
      }
    }
  });
  /*End: Quotation */

  /* Starting: sale_return btn*/
  $('#sale_return').on('click', function()
  {
      var id = $('#is_sale_active').val();
      if(id != ''){
        $.ajax({
          url     : '<?php echo base_url();?>sale_controller/createSaleReturn',
          type    : "POST",
          data    : {tmp_sale_id: id},
          success : function(result)
		  {
            $('#sale_return_modal').modal('show');
			var total_final = 0.00;
			$('.total_sale_price_final').each(function(){
				total_final += parseFloat($(this).text()); 
			});
			//alert(total_final);
			$('#total_sale_retrun_price').html(total_final);
          }
        });
      }
      else{
        swal(
          'Oops...!',
          'Please select a sale!',
          'info'
        );
      }
  });
  /* Ending: sale_return btn*/
  /* Start: sale Return*/
  $('#sale_return_from').on('submit', function(ev){
    ev.preventDefault();
    
  });
  /* End: sale Return*/

  $('#return_adjust').on('change', function(){
    alert('OK');
  });
  /* End: Script for sale. */
  
  
  /* Shortcut Add Start*/
	document.onkeyup=function(e)
{
		var e = e || window.event; // for IE to cover IEs window object
		if(e.altKey && e.which == 81) {
			 var is_sale_active   = $('#is_sale_active').val();

			if(!is_sale_active){
				swal(
				  'Oops...!',
				  'Please select a sale!',
				  'info'
				);
			}
			else
			{
				swal({
				  title               : 'Are You Sure About Quick Sale?',
				  text                : "You won't be able to revert this!",
				  type                : 'warning',
				  showCancelButton    : true,
				  confirmButtonColor  : '#db8b0b',
				  cancelButtonColor   : '#008d4c',
				  confirmButtonText   : 'Yes',
				  cancelButtonText    : 'No'
				}).then(function () {
					var sub_total       = parseFloat($('#sub_total').val());
					var vat             = parseFloat($('#vat').val());
					var total           = parseFloat($('#total').val());
					var received        = parseFloat($('#received').val());
					var customer_id     = $('#selected_customer_id').val();
					var disc_in_p       = parseFloat($('#disc_in_p').val());
					var disc_in_f       = parseFloat($('#disc_in_f').val());
					var disc_amount     = parseFloat($('#disc_amount').val());
					var customer_name   = $('#customer_name').val();
					var customer_phn    = $('#customer_phone').val();
					var return_adjust   = parseFloat($('#return_adjust').val());
					var change          = parseFloat($('#change').val());
					var payable          = parseFloat($('#payable').val());
					var return_id       = $('#hid_return_id').val();
					if(disc_amount > total)
					{
						swal(
							'Oops...!',
							'Discount Amount is Greater Than Total Amount!',
							'warning'
						  );
					}
					else
					{
						if(sub_total != '' && total != '')
						{
							$.ajax({
								url: '<?php echo base_url()?>sale_controller/doSale',
								type: "POST",
								cache: false,
								async: false,
								data: { 
									sub_total       : sub_total, 
									total_          : total, 
									customer_id     : customer_id, 
									disc_in_p       : disc_in_p, 
									disc_in_f       : disc_in_f,
									disc_amount     : disc_amount,
									received        : received,
									change          : change,
									customer_name   : customer_name,
									customer_phn    : customer_phn,
									return_adjust   : return_adjust,
									payable   		: payable,
									return_id   	: return_id,
									flg             : 1             /// for quick sale it is 1.
								},
								success:function(result)
								{
									$('#sub_total').val("");
									$('#vat').val("");
									$('#disc_in_p').val("");
									$('#disc_in_f').val("");
									$('#disc_amount').val("");
									$('#total').val("");
									$('#received').val("");
									$('#change').val("");
									$('#number_of_products').val("");
									$('#select_customer').val("");
									$('#customer_name').val("");
									$('#customer_phone').val("");
									$('#inword').val("");
									$('#return_id').val("");
									$("#selected_products").empty();
									$("#sale_return_list").empty();
									
									location.reload(); 
									$('#search_by_product_name').focus();
									window.open("<?php echo base_url()?>New_invoice_print/index/" + result, '_blank');          
								}  
							});
								
						}
					
						else 
						{
						  swal(
							'Oops...!',
							'Data Missing!',
							'warning'
						  );
						}
					}
				})
			}
		}
		
		else if(e.altKey && e.which == 77) {
			var is_sale_active   = $('#is_sale_active').val();

			if(!is_sale_active){
				swal(
				  'Oops...!',
				  'Please select a sale!',
				  'info'
				);
			}
			else
			{
				swal({
				  title               : 'Are You Sure About <img src="<?php echo base_url();?>assets/assets2/dist/img/credit/mastercard.png" alt="Mastercard"> Sale?',
				  text                : "You won't be able to revert this!",
				  type                : 'warning',
				  showCancelButton    : true,
				  confirmButtonColor  : '#db8b0b',
				  cancelButtonColor   : '#008d4c',
				  confirmButtonText   : 'Yes',
				  cancelButtonText    : 'No'
				}).then(function () {
					var bank_id       	= $('#bank_id').val();
					var card_id       	= $('#master_id').val();
					var sub_total       = $('#sub_total').val();
					var vat             = $('#vat').val();
					var total           = $('#total').val();
					var received        = $('#received').val();
					var customer_id     = $('#selected_customer_id').val();
					var disc_in_p       = $('#disc_in_p').val();
					var disc_in_f       = $('#disc_in_f').val();
					var disc_amount     = $('#disc_amount').val();
					var customer_name   = $('#customer_name').val();
					var customer_phn    = $('#customer_phone').val();
					var return_adjust   = $('#return_adjust').val();
					var change          = $('#change').val();
					var payable         = $('#payable').val();
					var return_id       = $('#hid_return_id').val();
				  
					if(return_adjust !='')
					{
						if(received != payable)
						{
							alert('Your Paid Amount is smaller then Payble.');
						}
						else if(received == payable && isNaN(customer_id))
						{
							alert('Please Select Customer');
						}
						else if(isNaN(received) && isNaN(customer_id))
						{
							alert('Please Select Paid Amount & Customer');
						}
						
						else
						{
							$.ajax({
								url: '<?php echo base_url()?>sale_controller/doSale_card',
								type: "POST",
								cache: false,
								async: false,
								data: { 
									sub_total       : sub_total, 
									total_          : total, 
									customer_id     : customer_id, 
									disc_in_p       : disc_in_p, 
									disc_in_f       : disc_in_f,
									disc_amount     : disc_amount,
									received        : received,
									change          : change,
									customer_name   : customer_name,
									customer_phn    : customer_phn,
									return_adjust   : return_adjust,
									card_id   		: card_id,
									bank_id   		: bank_id,
									payable   		: payable,
									return_id   	: return_id,
									flg             : 1             /// for quick sale it is 1.
								},
								success:function(result)
								{
									alert(result);
									$('#sub_total').val("");
									$('#vat').val("");
									$('#disc_in_p').val("");
									$('#disc_in_f').val("");
									$('#disc_amount').val("");
									$('#total').val("");
									$('#received').val("");
									$('#change').val("");
									$('#number_of_products').val("");
									$('#select_customer').val("");
									$('#customer_name').val("");
									$('#customer_phone').val("");
									$('#inword').val("");
									$('#return_id').val("");
									$("#selected_products").empty();
									$("#sale_return_list").empty();
									var card_id2 = $('#master_id').val();
									location.reload(); 
									$('#search_by_product_name').focus();
									window.open("<?php echo base_url();?>New_invoice_print/index2/" + result+'/'+ card_id2, '_blank');          
								}  
							});
							
						}
					}
					else if(received !='' && sub_total != '' && total != '')
					{
							$.ajax({
								url: '<?php echo base_url()?>sale_controller/doSale_card',
								type: "POST",
								cache: false,
								async: false,
								data: { 
									sub_total       : sub_total, 
									total_          : total, 
									customer_id     : customer_id, 
									disc_in_p       : disc_in_p, 
									disc_in_f       : disc_in_f,
									disc_amount     : disc_amount,
									received        : received,
									change          : change,
									customer_name   : customer_name,
									customer_phn    : customer_phn,
									return_adjust   : return_adjust,
									card_id   		: card_id,
									bank_id   		: bank_id,
									payable   		: payable,
									return_id   	: return_id,
									flg             : 1             /// for quick sale it is 1.
								},
								success:function(result){
									$('#sub_total').val("");
									$('#vat').val("");
									$('#disc_in_p').val("");
									$('#disc_in_f').val("");
									$('#disc_amount').val("");
									$('#total').val("");
									$('#received').val("");
									$('#change').val("");
									$('#number_of_products').val("");
									$('#select_customer').val("");
									$('#customer_name').val("");
									$('#customer_phone').val("");
									$('#inword').val("");
									$('#return_id').val("");
									$("#selected_products").empty();
									$("#sale_return_list").empty();
									var card_id2 = $('#master_id').val();
									location.reload(); 
									$('#search_by_product_name').focus();
									window.open("<?php echo base_url();?>New_invoice_print/index2/" + result+'/'+ card_id2, '_blank');          
								}  
							});
					}
					else {
					  swal(
						'Oops...!',
						'Data Missing!',
						'warning'
					  );
					}
				})
			}
		}
		else if(e.altKey && e.which == 86) {
			var is_sale_active   = $('#is_sale_active').val();

			if(!is_sale_active){
				swal(
				  'Oops...!',
				  'Please select a sale!',
				  'info'
				);
			}
			else
			{
				swal({
				  title               : 'Are You Sure About <img src="<?php echo base_url();?>assets/assets2/dist/img/credit/visa.png" alt="Visa Card"> Sale?',
				  text                : "You won't be able to revert this!",
				  type                : 'warning',
				  showCancelButton    : true,
				  confirmButtonColor  : '#db8b0b',
				  cancelButtonColor   : '#008d4c',
				  confirmButtonText   : 'Yes',
				  cancelButtonText    : 'No'
				}).then(function () 
				{
					var bank_id       	= $('#bank_id').val();
					var card_id       	= $('#master_id').val();
					var sub_total       = $('#sub_total').val();
					var vat             = $('#vat').val();
					var total           = $('#total').val();
					var received        = $('#received').val();
					var customer_id     = $('#selected_customer_id').val();
					var disc_in_p       = $('#disc_in_p').val();
					var disc_in_f       = $('#disc_in_f').val();
					var disc_amount     = $('#disc_amount').val();
					var customer_name   = $('#customer_name').val();
					var customer_phn    = $('#customer_phone').val();
					var return_adjust   = $('#return_adjust').val();
					var change          = $('#change').val();
					var payable         = $('#payable').val();
					var return_id       = $('#hid_return_id').val();
				  
					if(return_adjust !='')
					{
						if(received != payable)
						{
							alert('Your Paid Amount is smaller then Payble.');
						}
						else if(received == payable && isNaN(customer_id))
						{
							alert('Please Select Customer');
						}
						else if(isNaN(received) && isNaN(customer_id))
						{
							alert('Please Select Paid Amount & Customer');
						}
						
						else
						{
							$.ajax({
								url: '<?php echo base_url()?>sale_controller/doSale_card',
								type: "POST",
								cache: false,
								async: false,
								data: { 
									sub_total       : sub_total, 
									total_          : total, 
									customer_id     : customer_id, 
									disc_in_p       : disc_in_p, 
									disc_in_f       : disc_in_f,
									disc_amount     : disc_amount,
									received        : received,
									change          : change,
									customer_name   : customer_name,
									customer_phn    : customer_phn,
									return_adjust   : return_adjust,
									card_id   		: card_id,
									bank_id   		: bank_id,
									payable   		: payable,
									return_id   	: return_id,
									flg             : 1             /// for quick sale it is 1.
								},
								success:function(result)
								{
									alert(result);
									$('#sub_total').val("");
									$('#vat').val("");
									$('#disc_in_p').val("");
									$('#disc_in_f').val("");
									$('#disc_amount').val("");
									$('#total').val("");
									$('#received').val("");
									$('#change').val("");
									$('#number_of_products').val("");
									$('#select_customer').val("");
									$('#customer_name').val("");
									$('#customer_phone').val("");
									$('#inword').val("");
									$('#return_id').val("");
									$("#selected_products").empty();
									$("#sale_return_list").empty();
									var card_id2 = $('#master_id').val();
									location.reload(); 
									$('#search_by_product_name').focus();
									window.open("<?php echo base_url();?>New_invoice_print/index2/" + result+'/'+ card_id2, '_blank');          
								}  
							});
							
						}
					}
					else if(received !='' && sub_total != '' && total != '')
					{
							$.ajax({
								url: '<?php echo base_url()?>sale_controller/doSale_card',
								type: "POST",
								cache: false,
								async: false,
								data: { 
									sub_total       : sub_total, 
									total_          : total, 
									customer_id     : customer_id, 
									disc_in_p       : disc_in_p, 
									disc_in_f       : disc_in_f,
									disc_amount     : disc_amount,
									received        : received,
									change          : change,
									customer_name   : customer_name,
									customer_phn    : customer_phn,
									return_adjust   : return_adjust,
									card_id   		: card_id,
									bank_id   		: bank_id,
									payable   		: payable,
									return_id   	: return_id,
									flg             : 1             /// for quick sale it is 1.
								},
								success:function(result){
									$('#sub_total').val("");
									$('#vat').val("");
									$('#disc_in_p').val("");
									$('#disc_in_f').val("");
									$('#disc_amount').val("");
									$('#total').val("");
									$('#received').val("");
									$('#change').val("");
									$('#number_of_products').val("");
									$('#select_customer').val("");
									$('#customer_name').val("");
									$('#customer_phone').val("");
									$('#inword').val("");
									$('#return_id').val("");
									$("#selected_products").empty();
									$("#sale_return_list").empty();
									var card_id2 = $('#master_id').val();
									location.reload(); 
									$('#search_by_product_name').focus();
									window.open("<?php echo base_url();?>New_invoice_print/index2/" + result+'/'+ card_id2, '_blank');          
								}  
							});
					}
					else {
					  swal(
						'Oops...!',
						'Data Missing!',
						'warning'
					  );
					}
				})
			}
		}
		else if(e.altKey && e.which == 65) 
		{
			var is_sale_active   = $('#is_sale_active').val();

			if(!is_sale_active){
				swal(
				  'Oops...!',
				  'Please select a sale!',
				  'info'
				);
			}
			else
			{
				swal({
				  title               : 'Are You Sure About <img src="<?php echo base_url();?>assets/assets2/dist/img/credit/american-express.png" alt="American Express Card"> Sale?',
				  text                : "You won't be able to revert this!",
				  type                : 'warning',
				  showCancelButton    : true,
				  confirmButtonColor  : '#db8b0b',
				  cancelButtonColor   : '#008d4c',
				  confirmButtonText   : 'Yes',
				  cancelButtonText    : 'No'
				}).then(function () {
					var bank_id       	= $('#bank_id').val();
					var card_id       	= $('#master_id').val();
					var sub_total       = $('#sub_total').val();
					var vat             = $('#vat').val();
					var total           = $('#total').val();
					var received        = $('#received').val();
					var customer_id     = $('#selected_customer_id').val();
					var disc_in_p       = $('#disc_in_p').val();
					var disc_in_f       = $('#disc_in_f').val();
					var disc_amount     = $('#disc_amount').val();
					var customer_name   = $('#customer_name').val();
					var customer_phn    = $('#customer_phone').val();
					var return_adjust   = $('#return_adjust').val();
					var change          = $('#change').val();
					var payable         = $('#payable').val();
					var return_id       = $('#hid_return_id').val();
				  
					if(return_adjust !='')
					{
						if(received != payable)
						{
							alert('Your Paid Amount is smaller then Payble.');
						}
						else if(received == payable && isNaN(customer_id))
						{
							alert('Please Select Customer');
						}
						else if(isNaN(received) && isNaN(customer_id))
						{
							alert('Please Select Paid Amount & Customer');
						}
						
						else
						{
							$.ajax({
								url: '<?php echo base_url()?>sale_controller/doSale_card',
								type: "POST",
								cache: false,
								async: false,
								data: { 
									sub_total       : sub_total, 
									total_          : total, 
									customer_id     : customer_id, 
									disc_in_p       : disc_in_p, 
									disc_in_f       : disc_in_f,
									disc_amount     : disc_amount,
									received        : received,
									change          : change,
									customer_name   : customer_name,
									customer_phn    : customer_phn,
									return_adjust   : return_adjust,
									card_id   		: card_id,
									bank_id   		: bank_id,
									payable   		: payable,
									return_id   	: return_id,
									flg             : 1             /// for quick sale it is 1.
								},
								success:function(result)
								{
									alert(result);
									$('#sub_total').val("");
									$('#vat').val("");
									$('#disc_in_p').val("");
									$('#disc_in_f').val("");
									$('#disc_amount').val("");
									$('#total').val("");
									$('#received').val("");
									$('#change').val("");
									$('#number_of_products').val("");
									$('#select_customer').val("");
									$('#customer_name').val("");
									$('#customer_phone').val("");
									$('#inword').val("");
									$('#return_id').val("");
									$("#selected_products").empty();
									$("#sale_return_list").empty();
									var card_id2 = $('#master_id').val();
									location.reload(); 
									$('#search_by_product_name').focus();
									window.open("<?php echo base_url();?>New_invoice_print/index2/" + result+'/'+ card_id2, '_blank');          
								}  
							});
							
						}
					}
					else if(received !='' && sub_total != '' && total != '')
					{
							$.ajax({
								url: '<?php echo base_url()?>sale_controller/doSale_card',
								type: "POST",
								cache: false,
								async: false,
								data: { 
									sub_total       : sub_total, 
									total_          : total, 
									customer_id     : customer_id, 
									disc_in_p       : disc_in_p, 
									disc_in_f       : disc_in_f,
									disc_amount     : disc_amount,
									received        : received,
									change          : change,
									customer_name   : customer_name,
									customer_phn    : customer_phn,
									return_adjust   : return_adjust,
									card_id   		: card_id,
									bank_id   		: bank_id,
									payable   		: payable,
									return_id   	: return_id,
									flg             : 1             /// for quick sale it is 1.
								},
								success:function(result){
									$('#sub_total').val("");
									$('#vat').val("");
									$('#disc_in_p').val("");
									$('#disc_in_f').val("");
									$('#disc_amount').val("");
									$('#total').val("");
									$('#received').val("");
									$('#change').val("");
									$('#number_of_products').val("");
									$('#select_customer').val("");
									$('#customer_name').val("");
									$('#customer_phone').val("");
									$('#inword').val("");
									$('#return_id').val("");
									$("#selected_products").empty();
									$("#sale_return_list").empty();
									var card_id2 = $('#master_id').val();
									location.reload(); 
									$('#search_by_product_name').focus();
									window.open("<?php echo base_url();?>New_invoice_print/index2/" + result+'/'+ card_id2, '_blank');          
								}  
							});
					}
					else {
					  swal(
						'Oops...!',
						'Data Missing!',
						'warning'
					  );
					}
				})
			}
		}
		
		else if(e.altKey && e.which == 67) 
		{
			var is_sale_active   = $('#is_sale_active').val();

			if(!is_sale_active){
				swal(
				  'Oops...!',
				  'Please select a sale!',
				  'info'
				);
			}
			else
			{
				swal({
				  title               : 'Are You Sure About Credit Sale?',
				  text                : "You won't be able to revert this!",
				  type                : 'warning',
				  showCancelButton    : true,
				  confirmButtonColor  : '#db8b0b',
				  cancelButtonColor   : '#008d4c',
				  confirmButtonText   : 'Yes',
				  cancelButtonText    : 'No'
				}).then(function () 
				{
					var sub_total       = $('#sub_total').val();
					var vat             = $('#vat').val();
					var total           = $('#total').val();
					var received        = $('#received').val();
					var customer_id     = $('#selected_customer_id').val();
					var disc_in_p       = $('#disc_in_p').val();
					var disc_in_f       = $('#disc_in_f').val();
					var disc_amount     = $('#disc_amount').val();
					var customer_name   = $('#customer_name').val();
					var customer_phn    = $('#customer_phone').val();
					var return_adjust   = $('#return_adjust').val();
					var change          = $('#change').val();
					var payable          = $('#payable').val();
					var return_id          = $('#hid_return_id').val();
					if(disc_amount > total)
					{
						swal(
							'Oops...!',
							'Discount Amount is Greater Than Total Amount!',
							'warning'
						  );
					}
					else
					{
						if(sub_total != '' && total != '' && customer_id!='')
						{
							$.ajax({
								url: '<?php echo base_url()?>sale_controller/doSale_credit',
								type: "POST",
								cache: false,
								async: false,
								data: { 
									sub_total       : sub_total, 
									total_          : total, 
									customer_id     : customer_id, 
									disc_in_p       : disc_in_p, 
									disc_in_f       : disc_in_f,
									disc_amount     : disc_amount,
									received        : received,
									change          : change,
									customer_name   : customer_name,
									customer_phn    : customer_phn,
									return_adjust   : return_adjust,
									payable   		: payable,
									return_id   	: return_id,
									flg             : 1             /// for quick sale it is 1.
								},
								success:function(result)
								{
									$('#sub_total').val("");
									$('#vat').val("");
									$('#disc_in_p').val("");
									$('#disc_in_f').val("");
									$('#disc_amount').val("");
									$('#total').val("");
									$('#received').val("");
									$('#change').val("");
									$('#number_of_products').val("");
									$('#select_customer').val("");
									$('#customer_name').val("");
									$('#customer_phone').val("");
									$('#inword').val("");
									$('#return_id').val("");
									$("#selected_products").empty();
									$("#sale_return_list").empty();
									
									location.reload(); 
									$('#search_by_product_name').focus();
									window.open("<?php echo base_url()?>New_invoice_print/index/" + result, '_blank');          
								}  
							});
								
						}
					
						else 
						{
						  swal(
							'Oops...!',
							'Data Missing!',
							'warning'
						  );
						}
					}
				})
			}
		}
		
		else if(e.altKey && e.which == 88) 
		{
			var is_sale_active   = $('#is_sale_active').val();
        
			if(is_sale_active)
			{    
				swal({
				  title               : 'Are you sure?',
				  text                : "You won't be able to revert this!",
				  type                : 'warning',
				  showCancelButton    : true,
				  confirmButtonColor  : '#db8b0b',
				  cancelButtonColor   : '#008d4c',
				  confirmButtonText   : 'Yes',
				  cancelButtonText    : 'No'
				}).then(function () 
				{
					$('#sub_total').val("");
					$('#vat').val("");
					$('#disc_in_p').val("");
					$('#disc_in_f').val("");
					$('#disc_amount').val("");
					$('#total').val("");
					$('#received').val("");
					$('#change').val("");
					$('#number_of_products').val("");
					$('#select_customer').val("");
					$('#customer_name').val("");
					$('#customer_phone').val("");
					$("#selected_products").empty();
					$('#inword').val("");
					$('#return_adjust').val('');
					$('#payable').val('');
					$.ajax({
						url: '<?php echo base_url()?>sale_controller/cancelSale',
						type: "POST",
						cache: false,
						data: { },
						success:function(result){
						  swal(
							'Deleted!',
							'Your file has been deleted.',
							'success'
						  )
						  location.reload();
						  $('#search_by_barcode').focus();
						}

					});
				})
			}
		}

		else if(e.altKey && e.which == 83) 
		{
			$.ajax({
				url     : '<?php echo base_url()?>sale_controller/addNewSale',
				type    : "POST",
				cache   : false,
				data    : { },
				success : function(result){
					location.reload();
				}

			});
		}
	}
  
  /* Shortcut Add End*/
</script>

<script src="<?php echo base_url();?>assets/assets2/bootstrap/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url();?>assets/assets2/plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="<?php echo base_url();?>assets/assets2/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url();?>assets/assets2/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url();?>assets/assets2/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="<?php echo base_url();?>assets/assets2/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/assets2/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->

<script src="<?php echo base_url();?>assets/assets2/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url();?>assets/assets2/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="<?php echo base_url();?>assets/assets2/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?php echo base_url();?>assets/assets2/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?php echo base_url();?>assets/assets2/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>assets/assets2/plugins/fastclick/fastclick.js"></script>
<!-- adminLTE App -->
<script src="<?php echo base_url();?>assets/assets2/dist/js/app.min.js"></script>
<!-- adminLTE for demo purposes -->
<script src="<?php echo base_url();?>assets/assets2/dist/js/demo.js"></script>
<script src="<?php echo base_url();?>assets/assets2/date.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
	$(".select22").select2();
    $(".select2_bank").select2({
        placeholder     : 'Select Bank',
        allowClear      : true
    });

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });
	$('#customer_dob').datepicker({
      autoclose: true
    });

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>
<script>
	/* Start: Database Download. */
    $('#download_database').on('click', function(){
		swal({
		  title               : 'Are you sure?',
		  text                : "To Download Database!",
		  type                : 'warning',
		  showCancelButton    : true,
		  confirmButtonColor  : '#db8b0b',
		  cancelButtonColor   : '#008d4c',
		  confirmButtonText   : 'Yes',
		  cancelButtonText    : 'No'
		}).then(function () {
			 $.ajax({
				url: '<?php echo base_url()?>admin/download_database',
				type: "POST",
				cache: false,
				data: { },
				beforeSend: function(){
				 $(".modal12345").show();
				},
				success:function(result){
				$(".modal12345").hide();
				  swal(
					'Download',
					'Your database has been downloaded.',
					'success'
				  );
				}

			});
		})
    });
    /* End      : Database Download. */
</script>
<style type="text/css">
    .ui-state-active,
    .ui-widget-content .ui-state-active,
    .ui-widget-header .ui-state-active,
    a.ui-button:active,
    .ui-button:active,
    .ui-button.ui-state-active:hover {
        background-color: #0080b0;
        border: 1px solid #c3c3c3;
    }
</style>
<script  type="text/javascript">
$(document).ready(function()
{
	//$(window).focus(function(){ window.location.reload(); });
});
</script>
</body>
</html>
