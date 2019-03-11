				
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
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-1.12.4.js"></script>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets2/sweetalert2/sweetalert2.min.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/assets2/sweetalert2/sweetalert2.min.js"></script>
<script>
    $("#lock2").autocomplete({
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
            if(stock == 0){
                $('#lock2').val("");
                alert("Stock unavailable");
                $('#lock2').focus();
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
		   /* $( "#lock2" ).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li style=\"border-bottom: 1px solid gray;\">" )
      .append( "<div><span class=\"label_style\">" + item.label + "</span><br>" + item.generic_name + "    " +item.catagory_name + "    "+ item.stock + "<br>" + item.company_name + "</div>" ).appendTo( ul );
    }; */
</script>
<script>
    $("#lock3").autocomplete({
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
                      label           : item.product_name +'----(Company: ' + item.company_name + ')'  +  '----(Catagory: ' + item.catagory_name + ')'  +  '----(Stock:' + item.stock + ')',
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
            if(stock == 0){
                $('#lock3').val("");
                alert("Stock unavailable");
                $('#lock3').focus();
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
		  /* $( "#lock2" ).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li style=\"border-bottom: 1px solid gray;\">" )
      .append( "<div><span class=\"label_style\">" + item.label + "</span><br>" + item.generic_name + "    " +item.catagory_name + "    "+ item.stock + "<br>" + item.company_name + "</div>" ).appendTo( ul );
    }; */
</script>
<script>
    $("#lock33").autocomplete({
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
                      label           : item.product_name +'----(Company: ' + item.company_name + ')'  +  '----(Catagory: ' + item.catagory_name + ')'  +  '----(Stock:' + item.stock + ')',
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
            if(stock == 0){
                $('#lock3').val("");
                alert("Stock unavailable");
                $('#lock3').focus();
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
		  /* $( "#lock2" ).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li style=\"border-bottom: 1px solid gray;\">" )
      .append( "<div><span class=\"label_style\">" + item.label + "</span><br>" + item.generic_name + "    " +item.catagory_name + "    "+ item.stock + "<br>" + item.company_name + "</div>" ).appendTo( ul );
    }; */
</script>
<script>
    $("#lock333").autocomplete({
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
                      label           : item.product_name +'----(Company: ' + item.company_name + ')'  +  '----(Catagory: ' + item.catagory_name + ')'  +  '----(Stock:' + item.stock + ')',
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
            var product_idddd   = ui.item.id;
            var submiturl   = "<?php echo base_url();?>site_controller/searchBarcode";
            if(stock == 0){
                $('#lock333').val("");
                alert("Stock unavailable");
                $('#lock333').focus();
				
            }
            else{
				
              $('#pro_id').val(ui.item.id);
			  location.href =(submiturl+'/'+product_idddd);
            }
                   
            },

          });
		   //$( "#lock333" ).autocomplete( "instance" )._renderItem = function( ul, item ) {
      //return $( "<li style=\"border-bottom: 1px solid gray;\">" )
      //.append( "<div><span class=\"label_style\">" + item.label + "</span><br>" + item.generic_name + "    " +item.catagory_name + "    "+ item.stock + "<br>" + item.company_name + "</div>" ).appendTo( ul );
    //};
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

<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url();?>assets/assets2/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?php echo base_url();?>assets/assets2/bootstrap/js/bootstrap.min.js"></script>

<!-- DataTables -->
<script src="<?php echo base_url();?>assets/assets2/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/assets2/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url();?>assets/assets2/plugins/select2/select2.full.min.js"></script>

<script src="<?php echo base_url();?>assets/assets2/custom_script_2.js"></script>
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
<script src="<?php echo base_url();?>assets/assets2/date.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
    $(".select22").select2();
    $(".select222").select2();
    $(".select2222").select2();
    $(".select3").select2();
    $(".select33").select2();
    $(".select4").select2();
    $(".select44").select2();
    $(".select5").select2();
    $(".select6").select2();
	$(".select7").select2();
    $(".select8").select2();
    $(".select88").select2();
    $(".select888").select2();
    $(".select9").select2();
    $(".select10").select2();
    $(".select11").select2();
    $(".select12").select2();
    $(".select13").select2();
    $(".select14").select2();
    $(".select15").select2();
    $(".select16").select2();

     //Datemask dd/mm/yyyy
    $("#datemask").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'YYYY-MM-DD h:mm A'});
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
	$('#datepickerr').datepicker({
      autoclose: true
    });
	$('#datepickerrr').datepicker({
      autoclose: true
    });
	$('#datepicker2').datepicker({
      autoclose: true
    });
	$('#datepickerrrrrrrr').datepicker({
      autoclose: true
    });
	$('#datepickerrrrrrrrrr').datepicker({
      autoclose: true
    });
	$('#datepickerrrrrrrrr').datepicker({
      autoclose: true
    });
	$('#datepickerrrrrrrrrrrr').datepicker({
      autoclose: true
    });
	
	$('#datepickerrrrdfsdfsdfrrrrrrrr').datepicker({
      autoclose: true
    });
	$('#datepickerrrrdfsdffsdfrrrrrrrr').datepicker({
      autoclose: true
    });
	
	
	$('#datep').datepicker({
      autoclose: true
    });
	
	$('#datasep').datepicker({
      autoclose: true
    });
	$('#datepp').datepicker({
      autoclose: true
    });
	$('#datep2').datepicker({
      autoclose: true
    });
	
	$('#datep22').datepicker({
      autoclose: true
    });
	$('#datep23').datepicker({
      autoclose: true
    });
	
	$('#datedate').datepicker({
      autoclose: true
    });
	$('#start').datepicker({
      autoclose: true
    });
	$('#end').datepicker({
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


<!--script type="text/javascript">
  $(function(){
    
    $( "#search_by_product_name" ).autocomplete({
      source    : function( request, response ) {
        $.ajax( {
          url       : "<?php echo base_url();?>sale_controller/search_product",
          dataType  : "json",
          type      : "POST",
          data      : { term: request.term },
          success   : function( result ) { 
                  response( $.map(result, function(item){
                    return{
                      id              : item.id,
                      label           : item.product_name,
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
            if(stock == 0){
              $('#search_by_product_name').css({'background-color': 'red', 'color': 'black', 'border': 'none'});
                alert("Stock unavailable");
                $('#search_by_product_name').val("");
                $('#search_by_product_name').focus();
            }
            else{
                    
//                    $('#selected_products tr').each(function() {
//                        if(ui.item.label == $(this).find("td:nth-child(2)").text()){
//                            alert("You have already Selected this item");
//                        }
//                    });

              $('#price').val(ui.item.sale_price);
              $("#pro_name").val(ui.item.label);
              $("#temp_pro_data").val(ui.item.temp_pro_data);
              $("#temp_pro_qty").val(ui.item.stock);
              $("#product_quantity").focus();
            }
                   
//                $.ajax({
//                    url: '<?php //echo base_url()?>sale_controller/add_arun_sale_details',
//                    type: "POST",
//                    cache: false,
//                    data: {product_id: ui.item.id, product_name: ui.item.label, sale_price: ui.item.sale_price, stock: ui.item.stock, num: num_of_tr},
//                    success:function(res){
//                        $("#temp_pro_data").val(ui.item.temp_pro_data);
//                        $("#temp_pro_qty").val(ui.item.stock);
//                        $("#product_quantity").focus();
//                        $("#selected_products").last().append(res);
//                        $('#search').val("");
//                        $('#search').focus();
//                    }
//                });
            },

          });
          
    $( "#search_by_product_name" ).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li style=\"border-bottom: 1px solid gray;\">" )
      .append( "<div><span class=\"label_color\">" + item.label + "</span><br>" + item.generic_name + " | " + item.catagory_name + "  |  " + item.stock+ ".<br>" + item.company_name + "</div>" ).appendTo( ul );
    };

    var customer_available   = [ <?php echo $customer_info; ?> ]

    $('#select_customer').autocomplete({
                  
      source    : customer_available,
      minLength : 0,
      select    : function(event, ui){
          $('#selected_customer_name').val(ui.item.label);
          $('#selected_customer_phn').val(ui.item.customer_contact_no);
          $('#selected_customer_id').val(ui.item.id);
          
      },
                                
    }).autocomplete( "widget" ).addClass( "autocomplete_custom_cls_for_customer" );
  });
</script-->
<script  type="text/javascript">
$(document).ready(function()
{
	//$(window).focus(function(){ window.location.reload(); });
});
</script>
</body>
</html>
