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

  $(document).ready(function() {
    $("#reset_btn").click(function(event) {
    event.preventDefault();
      $('#lock22').val('');
      $('#datep').val('');
      $('#datep2').val('');
    });
  });