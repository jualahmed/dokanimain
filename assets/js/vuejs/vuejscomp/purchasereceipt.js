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
	        url: this.base_url+'purchase/all/'+this.pagno,
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
		        url: this.base_url+'purchase/all/'+pageno,
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

// purchase_form
$(document).ready(function () {
    $('#purchase').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function (res){
            	console.log(res)
                if (res.check == true) {
                    $('#purchase').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#purchase').find('p.text-danger').remove();
                    if (res.success == true) {
                        $('#purchase')[0].reset();
                        swal({
                            title: "Good job!",
                            text: "Purchase Created Successfully!",
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

    $(document).on('click', '.edit', function (e){
        e.preventDefault();
        $('#EditModel').modal('show');
        var purchase_id = $(this).attr('purchase_id');
        $.ajax({
            url: base_url+'purchase/find',
            method: 'post',
            data: {purchase_id:purchase_id},
            dataType: 'json',
            success: function (res){
                console.log(res);
                $('#purchase_id').val(res.purchase_id);
                $('#purchase_name').val(res.purchase_name);
                $('#purchase_address').val(res.purchase_address);
                $('#purchase_contact_no').val(res.purchase_contact_no);
                $('#purchase_email').val(res.purchase_email);
                $('#purchase_description').val(res.purchase_description);
            }
        });
    });

    $('#purchaseupdate').submit(function (e){
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
                    $('#purchaseupdate').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#purchaseupdate').find('p.text-danger').remove();
                    if (res.success == true) {
                        $('#purchaseupdate')[0].reset();
                        $('#purchaseupdate').modal('hide');
                        swal({
                            title: "Good job!",
                            text: "purchase updated successfully!",
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

$(document).ready(function() 
{
	$("#payment_mode").on("change",function()
	{
		var payment_mode_id = $(this).val();
		var receipt_type = $('#receipt_type').val();
		if(payment_mode_id==2) 
		{	
			$("#result_cheque").show(); 		
			$("#card_id_list").hide(); 		
		}
		else if(payment_mode_id==3) 
		{
			var outputs='';
			var urlx=base_url+'account/get_all_card';			
			$.ajax
			({
				url: urlx,
				type: 'POST',
				dataType: 'json',
				data: {'payment_mode_id':payment_mode_id},
				success:function(result)
				{	
					outputs+='<option value="">Select Card</option>';
					for(var i=0; i<result.length; i++ )
					{
					  outputs+='<option value="'+result[i].card_id+'">'+result[i].card_name+'</option>';
					}
					$("#card_id_list").show(); 
					$("#card_id").html(outputs);
					$("#result_cheque").hide();
				},
				error: function (jXHR, textStatus, errorThrown) {}
			});
			
		}
		else if(payment_mode_id==1) 
		{
			$("#card_id_list").hide(); 
			$("#result_cheque").hide(); 							
		}
		else 
		{
			$("#card_id_list").hide(); 
			$("#result_cheque").hide(); 							
		}
	});
		
	$('#purchase_amount').on('keyup', function()
	{
		  var purchase_amount   = $(this).val();
		  purchase_amount       = parseFloat(purchase_amount);
		  if(!isNaN(purchase_amount)){
			$('#final_amount').val(purchase_amount);
		  }
	});

	$('#transport_cost').on('keyup', function(){
		$(this).val();
	});

	$('#gift_on_purchase').on('keyup', function(){
		var discount        = 0;
		var purchase_amount = $('#purchase_amount').val();

		if(purchase_amount != ''){
		  purchase_amount   = parseFloat(purchase_amount);
		  var tmp_discount  = $(this).val();
		  discount          = parseFloat(tmp_discount);

		  if(!isNaN(purchase_amount) && !isNaN(discount)){

			var discount_amount   = ((purchase_amount * discount)/100);
			var final_amount      = (purchase_amount - discount);
			
			$('#final_amount').val(final_amount);
		  }
		}
	});
});