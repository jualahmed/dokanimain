var vuejsapp = new Vue({
	el:"#vuejsapp",
	data:{
		base_url:base_url,
		result:[],
		pagno:0,
		pagination:[]
	},
	created(){
		var self = this;
	    $.ajax({
	        url: this.base_url+'damageproduct/all/'+this.pagno,
	        type: 'GET',
	        dataType: 'json',
	        success: function(result) {
	         	self.result.push(result.result);
	         	self.pagination.push(result.pagination);
	        }
	    });
	},
	methods:{
		greetdd:function(pageno){
			this.result=[];
			this.pagination=[];
			var self = this;
		    $.ajax({
		        url: this.base_url+'damageproduct/all/'+pageno,
		        type: 'GET',
		        dataType: 'json',
		        success: function(result) {
		         	self.result.push(result.result);
		         	self.pagination.push(result.pagination);
		        }
		    });
		}
	}
})


jQuery(document).ready(function($) {
	$('#pagination').on('click','.page-link',function(e){
       e.preventDefault(); 
       var pageno = $(this).children().attr('data-ci-pagination-page');
       vuejsapp.$data.pagno=pageno;
       vuejsapp.greetdd(pageno)
    });
});

// damage_product_form
$(document).ready(function () {
    $('#damage_product').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function (res){
                if (res.check == true) {
                    $('#damage_product').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#damage_product').find('p.text-danger').remove();
                    if (res.success == true) {
                        $('#damage_product')[0].reset();
                        swal({
                            title: "Good job!",
                            text: "Damage_product Created successfully!",
                            icon: "success",
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                }else {
                    $.each(res.errors, function (key, value){
                        var el = $('.'+key);
                        el.removeClass('has-error').addClass(value.length > 0 ? 'has-error':'has-success').siblings('p.text-danger').remove();
                        el.after(value);
                    });
                }
            }
        });
    });

    $(document).on('click', '.edit', function (e){
        e.preventDefault();
        $('#EditModel').modal('show');
        var damage_product_id = $(this).attr('damage_product_id');
        $.ajax({
            url: base_url+'damage_product/find',
            method: 'post',
            data: {damage_product_id:damage_product_id},
            dataType: 'json',
            success: function (res){
                console.log(res);
                $('#damage_id').val(res.damage_product_id);
                $('#damage_product_name').val(res.damage_product_name);
                $('#damage_product_address').val(res.damage_product_address);
                $('#damage_product_contact_no').val(res.damage_product_contact_no);
                $('#damage_product_email').val(res.damage_product_email);
                $('#damage_product_description').val(res.damage_product_description);
            }
        });
    });

    $('#damage_productupdate').submit(function (e){
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            method: 'post',
            data: data,
            dataType: 'json',
            success: function (res){
                console.log(res)
                if (res.check == true) {
                    $('#damage_productupdate').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#damage_productupdate').find('p.text-danger').remove();
                    if (res.success == true) {
                        $('#damage_productupdate')[0].reset();
                        $('#damage_productupdate').modal('hide');
                        swal({
                            title: "Good job!",
                            text: "damage_product updated successfully!",
                            icon: "success",
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                }else {
                    $.each(res.errors, function (key, value){
                        var el = $('#'+key);
                        el.removeClass('has-error').addClass(value.length > 0 ? 'has-error':'has-success').siblings('p.text-danger').remove();
                        el.after(value);
                    });
                }
            }
        });
    });
});


jQuery(document).ready(function($) {
 $("#lockk3").autocomplete({
  source    : function( request, response ) {
    $.ajax( {
      url       : base_url+"damageproduct/search_product",
      dataType  : "json",
      type      : "POST",
      data      : { term: request.term},
      success   : function(result) {
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
});