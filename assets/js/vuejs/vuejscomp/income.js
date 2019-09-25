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
	        url: this.base_url+'expense/income_all/'+this.pagno,
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
		        url: this.base_url+'expense/income_all/'+pageno,
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

// income_form
$(document).ready(function () {
    $('#income').submit(function (e) {
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
                    $('#income').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#income').find('p.text-danger').remove();
                    if (res.success == true) {
                        swal({
                            title: "Good job!",
                            text: "Income Created successfully!",
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
        var income_id = $(this).attr('income_id');
        $.ajax({
            url: base_url+'expense/find',
            method: 'post',
            data: {income_id:income_id},
            dataType: 'json',
            success: function (res){
                console.log(res);
                $('#income_id').val(res.income_id);
                $('#income_name').val(res.income_name);
                $('#income_address').val(res.income_address);
                $('#income_contact_no').val(res.income_contact_no);
                $('#income_email').val(res.income_email);
                $('#income_description').val(res.income_description);
            }
        });
    });

    $('#incomeupdate').submit(function (e){
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
                    $('#incomeupdate').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#incomeupdate').find('p.text-danger').remove();
                    if (res.success == true) {
                        $('#incomeupdate')[0].reset();
                        $('#incomeupdate').modal('hide');
                        swal({
                            title: "Good job!",
                            text: "income updated successfully!",
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

$(document).ready(function() {
	$('#typessssssss').on('submit', function(expe){
		expe.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		 $.ajax({
			url: submiturl,
			type: methods,
			data: $(this).serialize(),
			success:function(result){
				$('#show_income_typ_modal').modal('hide');
				var re=JSON.parse(result);
				 $("#expense_type").html('');
                 $.each(re, function(d){
                    $("#expense_type").append('<option value="'+ this.type_id +'">'+ this.type_name +'</option>')
                })
			 },
			error: function (jXHR, textStatus, errorThrown) {html("")}
		});
		
	});
});
		
$(document).ready(function() {
	$('#add_service_provider_form').on('submit', function(service){
		service.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		 $.ajax({
			url: submiturl,
			type: methods,
			data: $(this).serialize(),
			success:function(result){
				$('#show_service_provider_modal').modal('hide');
				var re=JSON.parse(result);
				 $("#service_provider_id").html('');
                 $.each(re, function(d){
                    $("#service_provider_id").append('<option value="'+ this.service_provider_id +'">'+ this.service_provider_name +'</option>')
                })
			 },
			error: function (jXHR, textStatus, errorThrown) {html("")}
		});
		
	});
});

$(document).ready(function() {
	$("#payment_mode").on("change",function()
	{
		var output = '';
		var outputs = '';
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
	});
});