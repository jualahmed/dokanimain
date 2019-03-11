				
			
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      &#169; <?php echo $this->tank_auth->get_shopname(); ?>, <?php echo $this->tank_auth->get_shopaddress(); ?>.
    </div>
    <strong>&reg; <b>DOKANI</b> 
						&copy; <a href="#">IT Lab Solutions Ltd.</a> +8801842485222
  </footer>
 </div>

<script src="<?php echo base_url();?>assets/assets2/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->


<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets2/sweetalert2/sweetalert2.min.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/assets2/sweetalert2/sweetalert2.min.js"></script>


<!-- Jquery autocomplete -->
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-1.12.4.js"></script>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-ui.js"></script>

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
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/assets2/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>assets/assets2/dist/js/demo.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

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
      autoclose   : true,
      format      : 'dd-mm-yyyy'
    });
    $('#datepicker_modal').datepicker({
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

    var global_product_id           = 0;
    var global_purchase_receipt_id  = 0;
    var selected_row;

    $('#purchase_receipt_id').on('change', function()
	{
      var purchase_receipt_id = $(this).val();
      $('#pur_rec_id').val(purchase_receipt_id);
      if(purchase_receipt_id != '')
	  {

        $.ajax({
          url     : '<?php echo base_url();?>Report_controller/specificPurchaseReceipt',
          type    : 'POST',
          cash    : false,
          dataType: 'json',
          data    : {purchase_receipt_id: purchase_receipt_id},
          success : function(info)
		  {
            getProducts(purchase_receipt_id, info);
			var total_final = 0.00;
			$('.total_purchase_price_final').each(function(){
				total_final += parseFloat($(this).text()); 
			});
			$('#total_purchase_price_new_final').html(total_final.toFixed(2));
          }
        });
      }
    });
    /* Starting: getProducts() */
    function getProducts(purchase_receipt_id, data){

      $.ajax({
        url     : '<?php echo base_url();?>Report_controller/getSpecificPurchaseReceiptProduct',
        type    : 'POST',
        cash    : false,
        data    : {purchase_receipt_id: purchase_receipt_id},
        success : function(info)
        {
			var total_final = 0.00;
			$('.total_purchase_price_final').each(function(){
				total_final += parseFloat($(this).text()); 
			});
			
			$('#total_purchase_price_new_final').html(total_final.toFixed(2));
			
            $('#grand_total').val(data['grand_total']);
            $('#total_purchase_amount').val(data['total_purchase_amount']);
            $('#general_info').html(data['basic_info']);
            $('#purchase_products').html(info);
            $('#search_by_name').focus();
            
        }
      });
    }
	function getProducts2(purchase_receipt_id)
	{

      $.ajax({
        url     : '<?php echo base_url();?>Report_controller/getSpecificPurchaseReceiptProduct',
        type    : 'POST',
        cash    : false,
        data    : {purchase_receipt_id: purchase_receipt_id},
        success : function(info)
        {
			var total_final = 0.00;
			$('.total_purchase_price_final').each(function(){
				total_final += parseFloat($(this).text()); 
			});
			
			$('#total_purchase_price_new_final').html(total_final.toFixed(2));

            $('#purchase_products').html(info);
            $('#search_by_name').focus();
            
        }
      });
    }
    /* Ending: getProducts()*/
    $('#add_purchase_receipt').on('submit', function(event){
      event.preventDefault();
    
      var distributor_id    = $('#distributor_id option:selected').attr('id');
      var purchase_amount   = $('#purchase_amount').val();
      var transport_cost    = $('#transport_cost').val();
      var discount          = $('#discount').val();
      var final_amount      = $('#final_amount').val();
      var date              = $('#datepicker_modal').val();
      
      if(distributor_id != '' && purchase_amount != '' && transport_cost != '' && final_amount != '')
      {
          if(!isNaN(distributor_id) && distributor_id > 0 && !isNaN(purchase_amount) && purchase_amount >= 0 && !isNaN(transport_cost) && transport_cost >= 0 && !isNaN(final_amount))
          {
              $("#save_info").attr("disabled", "disabled");
              $("#close_frm").attr("disabled", "disabled");

              $.ajax({
                url     : '<?php echo base_url();?>product_controller/newCreatePurchaseReceipt',
                type    : 'POST',
                cash    : false,
                data    : {
                            distributor_id    : distributor_id, 
                            purchase_amount   : purchase_amount, 
                            transport_cost    : transport_cost, 
                            discount          : discount,
                            final_amount      : final_amount,
                            date              : date
                          },

                success : function(info){
                  $('#close_frm').removeAttr('disabled');
                  $('#save_info').removeAttr('disabled');
                  $('#purchase_receipt_id').html(info);
                  $('#add_purchase_receipt').modal('hide');
                  swal('Great!','Data Successfully added!','success');
                }
              });
          }
          else {
            swal('Oops...!', 'Invalid data...!', 'warning');
          }
      }
      else{
        swal('Oops...!', 'Data Missing...!', 'warning');
      }
    });

    $('#purchase_amount').on('keyup', function(){
      purchase_amount = $(this).val();

      if(purchase_amount != ''){
        purchase_amount = parseFloat(purchase_amount);
        if(!isNaN(purchase_amount)){
          $('#final_amount').val(purchase_amount);
        }
      }
      else if(purchase_amount == ''){
        $('#final_amount').val('');
      }
    });

    $('#discount').on('keyup', function(){
      var purchase_amount = $('#purchase_amount').val();
      var discount        = $('#discount').val();
      var final_amount    = 0;

      if(purchase_amount != '' && discount != ''){
        purchase_amount = parseFloat(purchase_amount);
        discount        = parseFloat(discount);

        if(!isNaN(purchase_amount) && !isNaN(discount)){
          var tmp       = ((purchase_amount * discount)/100);
          final_amount  = purchase_amount - tmp;
          $('#final_amount').val(Math.round(final_amount));
        }
      }
    });

    /* Starting: search_by_name*/
    
    $( "#search_by_name" ).autocomplete({
      source  : function( request, response ){
        $.ajax({
          url       : "<?php echo base_url();?>product_controller/searchProduct_2",
          dataType  : "json",
          type      : 'POST',
          data      : {
                      term  : request.term,
                      flag  : 1
          },
          success: function( data ){
            response( $.map(data, function(item){
              return{
                id              : item.id,
                label           : item.name,
                catagory_name   : item.catagory_name,
                company_name    : item.company_name,
                group_name      : item.group_name,
                product_size      : item.product_size,
                product_model      : item.product_model,
				bulk_unit_buy_price 		: item.bulk_unit_buy_price,
				unit_buy_price 				: item.unit_buy_price,
				bulk_unit_sale_price 		: item.bulk_unit_sale_price,
				general_unit_sale_price 	: item.general_unit_sale_price
				
              }
            }));
          }
        });
      },
      minLength: 3,
      select: function( event, ui )
	  {
        var unit_buy_price          = parseFloat(ui.item.bulk_unit_buy_price);
        var unit_buy_price_purchase = parseFloat(ui.item.unit_buy_price);
        var general_sale_price      = parseFloat(ui.item.bulk_unit_sale_price);
        var exclusive_sale_price    = parseFloat(ui.item.general_unit_sale_price);
		$('#unit_buy_price').val(unit_buy_price.toFixed(2));
		if(unit_buy_price_purchase =='')
		{
		$('#unit_buy_price_purchase').val(unit_buy_price.toFixed(2));
		}
		else
		{
		$('#unit_buy_price_purchase').val(unit_buy_price_purchase.toFixed(2));
		}
		$('#general_sale_price').val(general_sale_price.toFixed(2));
		$('#exclusive_sale_price').val(exclusive_sale_price.toFixed(2));
		
        $('#product_name').val(ui.item.label);
        $('#product_id').val(ui.item.id);
        $('#quantity').focus();
      }
    });
	$( "#search_by_name" ).autocomplete( "instance" )._renderItem = function( ul, item ) 
	{
	  return $( "<li style=\"border-bottom: 2px solid gray; hover: red;\">" )
	  .append( "<div><span class=\"label_style\">" + item.label +' '+item.catagory_name +' '+item.product_size +"</span><br>" + item.group_name + "    " +item.catagory_name + "  <span style='color:#00cd6e;'> (Pack: "+ item.product_model + ")</span><br>" + item.company_name + "</div>" ).appendTo( ul );
	};
    /* Ending: search_by_name*/

    /* Starting: search_by_barcode */

    
    $('#search_by_barcode').on('keyup', function(ev){
        ev.preventDefault();

        if(ev.which == 13)
        {
            var barcode = $(this).val();

            if(barcode != '')
            {
                $.ajax({
                    url         : "<?php echo base_url();?>product_controller/search_product_by_barcode",
                    type        : 'POST',
                    dataType    : 'json',
                    data        : { barcode: barcode },
                    success     : function(result)
                    {
                        $('#search_by_barcode').val(result['product_name']);
                        $('#product_name').val(result['product_name']);
                        $('#product_id').val(result['product_id']);
						
						if(result['unit_buy_price'] =='')
						{
						$('#unit_buy_price_purchase').val(result['bulk_unit_buy_price']);
						}
						else
						{
						$('#unit_buy_price_purchase').val(result['unit_buy_price']);
						}

						$('#general_sale_price').val(result['bulk_unit_sale_price']);
						$('#exclusive_sale_price').val(result['general_unit_sale_price']);
                        $('#quantity').focus();
                    }

                });
            }
        }

    });
    /*Ending: search_by_barcode*/


    $('#product_listing_form').on('submit', function(event){
        event.preventDefault();
        var purchase_receipt_id   = $('#pur_rec_id').val();
        var pro_name              = $('#product_name').val();
        var pro_id                = $('#product_id').val();
        var qnty                  = $('#quantity').val();
        var ex_date               = $('#datepicker').val();
        var total_buy_price       = $('#total_buy_price').val();
        var general_sale_price    = $('#general_sale_price').val();
        var unit_buy_price        = $('#unit_buy_price_purchase').val();
        var exclusive_sale_price  = $('#exclusive_sale_price').val();
        if($('#exclusive_sale_price').val() == '')
		{ 
            exclusive_sale_price = 0; 
        }

      if(purchase_receipt_id != '' && pro_name != '' && qnty != '' && total_buy_price != '' && general_sale_price != '' && unit_buy_price != '')
      {
        var is_exist            = false;
        var is_ok               = false;
        var row                 = '';
        var old_quantity        = 0;
        var old_unit_buy_price  = 0;
        var old_total_price     = 0;
        var new_qnty            = 0;
        
        $('#purchase_products tr').each(function() {
          if(pro_id == $(this).find("td:nth-child(2)").text()){
            row                   = $(this);
            is_exist              = true;
            old_quantity          = parseFloat(row.find('td:nth-child(4)').text());
            old_unit_buy_price    = parseFloat(row.find('td:nth-child(5)').text());
            old_total_price       = parseFloat(row.find('td:nth-child(6)').text());

            qnty                  = Math.abs(parseFloat(qnty));
            unit_buy_price        = Math.abs(parseFloat(unit_buy_price));
            total_buy_price       = Math.abs(parseFloat(total_buy_price));
                
            new_qnty              = (old_quantity + qnty);
            total_buy_price       = parseFloat((old_total_price + (unit_buy_price * qnty)).toFixed(2));
          }
        });

        if(!isNaN(qnty) && qnty > 0 && !isNaN(total_buy_price) && total_buy_price >= 0 && 
          !isNaN(general_sale_price) && general_sale_price > 0 && !isNaN(unit_buy_price) && unit_buy_price >= 0 && !isNaN(exclusive_sale_price)){
            is_ok   = true;
        }
        if(!is_ok)
        {
          swal(
            'Oops...!',
            'Invalid data!',
            'warning'
            );
        }
        /* else if(is_exist && is_ok)
        {
			alert('1');
            var grand_total             = Math.round(parseFloat($('#grand_total').val()));
            var total_purchase_amount   = Math.round(parseFloat($('#total_purchase_amount').val()));

            $.ajax({
                url       : "<?php echo base_url();?>product_controller/updateExistsProduct",
                type      : 'POST',
                cash      : false,
                data      : {
                              purchase_receipt_id   : purchase_receipt_id,
                              pro_name              : pro_name,
                              pro_id                : pro_id,
                              qnty                  : qnty,
                              ex_date               : ex_date,
                              total_buy_price       : total_buy_price,
                              general_sale_price    : general_sale_price,
                              unit_buy_price        : unit_buy_price,
                              exclusive_sale_price  : exclusive_sale_price,
                              grand_total           : grand_total,
                              total_purchase_amount : total_purchase_amount
                            },
                success: function(data)
                {
                    row.find('td:nth-child(4)').html(new_qnty);
                    row.find('td:nth-child(5)').html(unit_buy_price);
                    row.find('td:nth-child(6)').html(total_buy_price);
                    $('#search_by_name').val("");
                    $('#search_by_barcode').val("");
                    $('#product_id').val("");
                    $('#quantity').val("");
                    $('#datepicker').val("");
                    $('#total_buy_price').val(""); 
                    $('#general_sale_price').val("");
                    $('#unit_buy_price').val("");
                    $('#unit_buy_price_purchase').val("");
                    $('#exclusive_sale_price').val("");
                    $('#search_by_name').focus();
					var total_final = 0.00;
					$('.total_purchase_price_final').each(function(){
						total_final += parseFloat($(this).text()); 
					});
					
					$('#total_purchase_price_new_final').html(total_final);
                }
            });
        } */
        else if(is_ok)
        {
			//alert('2');
            var grand_total             = Math.round(parseFloat($('#grand_total').val()));
            var total_purchase_amount   = Math.round(parseFloat($('#total_purchase_amount').val()));

            $.ajax({
              url       : "<?php echo base_url();?>product_controller/addProductToList",
              type      : 'POST',
              cash      : false,
              data      : {
                            purchase_receipt_id     : purchase_receipt_id,
                            pro_name                : pro_name,
                            pro_id                  : pro_id,
                            qnty                    : qnty,
                            ex_date                 : ex_date,
                            total_buy_price         : total_buy_price,
                            general_sale_price      : general_sale_price,
                            unit_buy_price          : unit_buy_price,
                            exclusive_sale_price    : exclusive_sale_price,
                            grand_total             : grand_total,
                            total_purchase_amount   : total_purchase_amount
                        },
              success: function(data)
              {
				  
				  getProducts2($('#purchase_receipt_id').val());
                 // $('#purchase_products').last().append(data);
                  $('#search_by_name').val("");
                  $('#search_by_barcode').val("");
                  $('#product_id').val("");
                  $('#quantity').val("");
                  $('#datepicker').val("");
                  $('#tp_total').val("");
                  $('#vat_total').val("");
                  $('#unit_buy_price_purchase').val("");
                  $('#total_buy_price').val("");
                  $('#general_sale_price').val("");
                  $('#unit_buy_price').val("");
                  $('#exclusive_sale_price').val("");
                  $('#search_by_name').focus();
				var total_final = 0.00;
				$('.total_purchase_price_final').each(function(){
					total_final += parseFloat($(this).text()); 
				});
				
				$('#total_purchase_price_new_final').html(total_final);
              }
            });
        }
      }
      else{
        swal(
            'Oops...!',
            'Data Missing!',
            'warning'
          );
      }
    });
    /* Starting: Reset. */
    $('#reset').on('click', function(){
      $('#search_by_name').val("");
      $('#search_by_barcode').val();
      $('#product_id').val("");
      $('#quantity').val("");
      $('#datepicker').val("");
      $('#total_buy_price').val("");
      $('#general_sale_price').val("");
      $('#unit_buy_price').val("");
      $('#exclusive_sale_price').val("");
      $('#search_by_name').focus();
    });
    /* Ending: Reset. */
    
    $('#purchase_products').on('click', "[name='remove']", function(){
      var product_id            = $(this).attr('id');
      var purchase_receipt_id   = $('#pur_rec_id').val();
      var tr                    = $(this);
	  
      if(product_id != '' && purchase_receipt_id != '')
	  {
        swal({
            title               : 'Are you sure?',
            text                : "You won't be able to revert this!",
            type                : 'warning',
            showCancelButton    : true,
            confirmButtonColor  : '#db8b0b',
            cancelButtonColor   : '#419641',
            cancelButtonText    : 'No',
            confirmButtonText   : 'Yes'
          }).then(function () {
			  
              $.ajax({
                url       : "<?php echo base_url();?>product_controller/removeProductFromPurchase",
                type      : 'POST',
                cash      : false,
                data      : {purchase_receipt_id: purchase_receipt_id, pro_id: product_id},
                success: function(result)
                {
					
                  tr.closest('tr').remove();
					var total_final = 0.00;
					$('.total_purchase_price_final').each(function(){
						total_final += parseFloat($(this).text()); 
					});
					$('#total_purchase_price_new_final').html(total_final);
                  swal(
                    'Deleted!',
                    'Product has been deleted.',
                    'success'
                  );
				  
                }
              });
          })
      }

    });
    $('#purchase_products').on('click', "[name='edit']", function(ev)
	{
      ev.preventDefault();
	  
      global_product_id                 = $(this).attr('id');
      global_purchase_receipt_id        = $('#pur_rec_id').val();
      selected_row                      = $(this);
	   var old_qty     = parseFloat(selected_row.closest('tr').find('td:nth-child(4)').text());
       var old_tp      = parseFloat(selected_row.closest('tr').find('td:nth-child(5)').text());

      $('#edit_modal').modal('show');
      $('#qty').val(old_qty);
      $('#u_b_p').val(old_tp);

    });

    $('#edit_modal_form').on('submit', function(ev){
        ev.preventDefault();
        var qty             = $('#qty').val();
        var unit_buy_price  = $('#u_b_p').val();

        /*swal*/
        if(qty != '' && qty > 0 && !isNaN(qty) && unit_buy_price !='' && unit_buy_price > 0 && !isNaN(unit_buy_price)){
            swal({
                title               : 'Are you sure?',
                text                : ":)",
                type                : 'warning',
                showCancelButton    : true,
                confirmButtonColor  : '#db8b0b',
                cancelButtonColor   : '#419641',
                confirmButtonText   : 'Yes',
                cancelButtonText    : 'No'
            }).then(function (){
                var old_qty     = parseFloat(selected_row.closest('tr').find('td:nth-child(4)').text());
                var old_tp      = parseFloat(selected_row.closest('tr').find('td:nth-child(5)').text());
                qty             = parseFloat(qty);
                unit_buy_price  = parseFloat(unit_buy_price);
				
                $.ajax({
                  url       : '<?php echo base_url();?>product_controller/editPruchaseProduct',
                  type      : 'POST',
                  data      : {
                                pro_id                : global_product_id,
                                purchase_receipt_id   : global_purchase_receipt_id, 
                                qty                   : qty, 
                                u_b_p                 : unit_buy_price
                              },
                  success   : function(info)
				  {
					// getProducts2($('#purchase_receipt_id').val());
					selected_row.closest('tr').find('td:nth-child(4)').html(qty);
                    selected_row.closest('tr').find('td:nth-child(5)').html(unit_buy_price);
                    selected_row.closest('tr').find('td:nth-child(6)').html(Math.round(qty * unit_buy_price));
                    $('#edit_modal_form').trigger("reset");
                    $('#edit_modal').modal('hide');
					
					var total_final = 0.00;
					$('.total_purchase_price_final').each(function(){
						total_final += parseFloat($(this).text()); 
					});
					$('#total_purchase_price_new_final').html(total_final);

                    swal(
                      'Edited!',
                      'Data has been edited.',
                      'success'
                    );
                  }
                });
            }, function (dismiss) {
                if (dismiss === 'cancel') {
                  $('#edit_modal_form').trigger("reset");
                  $('#edit_modal').modal('hide');
                  swal(
                    'Canceled',
                    ':)',
                    'info'
                  )
                }
            })
        }
        else{
          $('#edit_modal_form').trigger("reset");
          swal(
            'Oops...!',
            'Invalid Data!!!',
            'error'
          );
        }
        /*swal*/
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
				url: '<?php echo base_url()?>site_controller/download_database',
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
<script  type="text/javascript">
$(document).ready(function()
{
	//$(window).focus(function(){ window.location.reload(); });
});
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
</body>
</html>
