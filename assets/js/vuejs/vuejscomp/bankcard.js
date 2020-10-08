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
	        url: this.base_url+'customer/all/'+this.pagno,
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
		        url: this.base_url+'customer/all/'+pageno,
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

// customer_form
$(document).ready(function () {
    $('#bank').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function (res){
                console.log(res);
                if (res.check == true) {
                    $('#customer').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#customer').find('p.text-danger').remove();
                    if (res.success == true) {
                        swal({
                            title: "Good job!",
                            text: "Bank Created successfully!",
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
        var customer_id = $(this).attr('customer_id');
        $.ajax({
            url: base_url+'customer/find',
            method: 'post',
            data: {customer_id:customer_id},
            dataType: 'json',
            success: function (res){
                console.log(res);
                $('#customer_id').val(res.customer_id);
                $('#customer_name').val(res.customer_name);
                $('#customer_address').val(res.customer_address);
                $('#customer_contact_no').val(res.customer_contact_no);
                $('#customer_email').val(res.customer_email);
                $('#customer_mode').val(res.customer_mode);
                $('#int_balance').val(res.int_balance);
                $('#customer_type').val(res.customer_type);
            }
        });
    });

    $('#customerupdate').submit(function (e){
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
                    $('#customerupdate').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#customerupdate').find('p.text-danger').remove();
                    if (res.success == true) {
                        $('#customerupdate')[0].reset();
                        $('#customerupdate').modal('hide');
                        swal({
                            title: "Good job!",
                            text: "customer updated successfully!",
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
