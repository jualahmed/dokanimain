 $("#lock22").autocomplete({
      source    : function( request, response ) {
        $.ajax( {
          url       : "<?php echo base_url();?>Report/search_product",
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


     $(document).ready(function() {
  $("#lock22").keyup(function(){
    var length=$('#lock22').val().length;
     if(length>=1){
       $("#lock3").prop("disabled", true);
       $("#lock4").prop("disabled", true);
       $("#lock5").prop("disabled", true);
       $("#datep").prop("disabled", true);
       $("#datep2").prop("disabled", true);
     }
      else{
       $("#lock3").prop("disabled", false);
       $("#lock4").prop("disabled", false);
       $("#lock5").prop("disabled", false);
       $("#datep").prop("disabled", false);
       $("#datep2").prop("disabled", false);
      }
  });
});


     $(document).ready(function() 
{
    $("#form_6").submit(function(event) {
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
         $(".modal").show();
      },
      success: function(result) { 
        $(".modal").hide();
        for(i=0; i<result.length; i++){   
          var unit_buy_price1  =parseFloat(Math.round(result[i].unit_buy_price)).toFixed(2);
          output2+='<table class="new_data_2"><tr><td style="width: 3%;">'+k+'</td><td style="width: 4%;">'+result[i].doc+'</td><td style="width: 4%;">'+result[i].product_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width: 20%;" title="'+result[i].product_name+'">'+result[i].product_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].company_name+'">'+result[i].company_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].catagory_name+'">'+result[i].catagory_name+'</td><td style="text-align:center;">'+result[i].damage_quantity+'</td><td style="text-align:right;">'+unit_buy_price1+'</td></tr></table>';
          k++;

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
          $('#down').show();
        }
        var product1 = $('#pro_id').val();
        var catagory1 = $('#lock3').val();
        var company1 = $('#lock4').val();
        var start1 = $('#datepickerrr').val();
        var end1 = $('#datepickerr').val();

        $('#product').val(product1);
        $('#category').val(catagory1);
        $('#company').val(company1);
        $('#start').val(start1);
        $('#end').val(end1);
        
        $('.product2').text(product1);
        $('.category2').text(catagory1);
        $('.company2').text(company1);
        $('.start2').text(start1);
        $('.end2').text(end1);
        
        
        $('#lock3').val('');
        $('#lock3').select2();
        $('#lock4').val('');
        $('#lock4').select2();
        $('#lock5').val('');
        $('#lock5').select2();
        $('#datepickerrr').val('');
        $('#lock111').val('');
        $('#datepickerr').val('');

      }
    });
  });
  $("#down").click(function(event2) 
  {
    event2.preventDefault();
    submiturl = $(this).attr('href');
    
    var product = $('#product').val();
    var category = $('#category').val();
    var company = $('#company').val();
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
    if(start == ''){
      start = 'null';
    }
    if(end == ''){
      end = 'null';
    }

    window.open(submiturl+'/'+product+'/'+category+'/'+company+'/'+start+'/'+end,'_blank');
  });
  
});


     $(document).ready(function() {
    $("#reset_btn").click(function(event) {
    event.preventDefault();
        $('#lock3').val('');
        $('#lock3').select2();
        $('#lock4').val('');
        $('#lock4').select2();
        $('#lock5').val('');
        $('#lock5').select2();
        $('#lock22').val('');
        $('#datep').val('');
        $('#datep2').val('');
    });
  });