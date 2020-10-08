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
    $("#distributor_id").select2();
    $("#payment_mode").select2();
    $("#my_bank").select2();
    $("#to_bank").select2();
    $("#card_id").select2();
	$('#pagination').on('click','.page-link',function(e){
       e.preventDefault(); 
       var pageno = $(this).children().attr('data-ci-pagination-page');
       vuejsapp.$data.pagno=pageno;
       vuejsapp.greetdd(pageno)
    });
});

// purchase_form
$(document).ready(function () {
	$('#distributor').submit(function (e) {
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
                    $('#distributor').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#distributor').find('p.text-danger').remove();
                    if (res.success == true) {
						$('#distributor')[0].reset();
						$("#distributorModal").modal('hide');
						$("#distributor_id").append(`<option value="${res.output.distributor_id}">${res.output.distributor_name}</option>`);
						$("#distributor_id").val(res.output.distributor_id);
                        swal({
                            title: "Good job!",
                            text: "Distributor Created successfully!",
                            icon: "success",
                        });
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
            url: base_url+'purchase/find/'+purchase_id,
            method: 'post',
            data: {purchase_id:purchase_id},
            dataType: 'json',
            success: function (res){
                console.log(res);
                $('#purchase_id').val(res.receipt_id);
                $('#supplier_id').val(res.supplier_id);
                $('#total_paids').val(res.total_paid);
                $('#purchase_amounts').val(res.purchase_amount);
                $('#transport_costs').val(res.transport_cost);
                $('#discounts').val(res.gift_on_purchase);
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
                            text: "Purchase updated successfully!",
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
			$(".result_cheque").show(); 		
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
					$(".result_cheque").hide();
				},
				error: function (jXHR, textStatus, errorThrown) {}
			});
			
		}
		else if(payment_mode_id==1) 
		{
			$("#card_id_list").hide(); 
			$(".result_cheque").hide(); 							
		}
		else 
		{
			$("#card_id_list").hide(); 
			$(".result_cheque").hide(); 							
		}
	});
		
	$('#purchase_amount').on('keyup', function()
	{
		  calculateFinalAmount();
	});

	$('#transport_cost').on('keyup', function(){
        calculateFinalAmount();
	});

	$('#gift_on_purchase').on('keyup', function(){
        calculateFinalAmount();
    });
    
    function calculateFinalAmount() {
        var discount  = $("#gift_on_purchase").val();
		var purchase_amount = $('#purchase_amount').val();
        var transport_cost = $('#transport_cost').val();
        var final_amount = 0;

        discount  = parseFloat(discount);
		purchase_amount = parseFloat(purchase_amount);
        transport_cost = parseFloat(transport_cost);

        if (!isNaN(purchase_amount)) {
            final_amount += purchase_amount;
        }

        if (!isNaN(transport_cost)) {
            final_amount += transport_cost;
        }

        if (!isNaN(discount)) {
            final_amount -= discount;
        }

        $('#final_amount').val(final_amount);
    }
});