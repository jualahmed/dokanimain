var vuejsapp = new Vue({
	el:"#vuejsapp",
	data:{
		base_url:base_url,
		result:[],
		pagno:0,
		pagination:[],
        row:0,
        rowperpage:0,
        total:0,
	},
	created(){
		var self = this;
	    $.ajax({
	        url: this.base_url+'product/all/'+this.pagno,
	        type: 'GET',
	        dataType: 'json',
	        success: function(result) {
                   self.rowperpage=result.rowperpage;
                self.total=result.total;
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
		        url: this.base_url+'product/all/'+pageno,
		        type: 'GET',
		        dataType: 'json',
		        success: function(result) {
                         self.rowperpage=result.rowperpage;
                    self.row=result.row;
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

// product_form
$(document).ready(function () {
    $('#product').submit(function (e) {
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
                    $('#product').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#product').find('p.text-danger').remove();
                    if (res.success == true) {
                        var file_data = $('#file').prop('files')[0];
                        var form_data = new FormData();
                        form_data.append('file', file_data);
                        $.ajax({
                            url: base_url+'product/upload_file/'+res.id, // point to server-side controller method
                            dataType: 'text', // what to expect back from the server
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,
                            type: 'post',
                            success: function (response) {
                                console.log(response)
                                $('#msg').html(response); // display success response from the server
                            },
                            error: function (response) {
                                $('#msg').html(response); // display error response from the server
                            }
                        });
                        $('#product')[0].reset();
                        swal({
                            title: "Good job!",
                            text: "Product Created successfully!",
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
        
    
     // fatch category without refresh page for outside category model
    $('#categoryinsertformproduct').submit(function (e) {
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
                    $('#category').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#category').find('p.text-danger').remove();
                    if (res.success == true) {
                        $("select[name='catagory_id'").html('');
                        $.each(res.data, function(){
                            $("select[name='catagory_id'").append('<option value="'+ this.catagory_id +'">'+ this.catagory_name +'</option>')
                        })
                        $('#catagory_id').val('');
                        $('#catagory_name').val('');
                        $('#catagory_description').val('');
                        $('#cModel').find('input.form-control').removeClass('has-error').removeClass('has-success');
                        $('#cModel').find('p.text-danger').remove();
                        $('#cModel').modal('hide');
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

    // fatch onpamy without refresh page for outside category model
    $('#conpamyinsertformproduct').submit(function (e) {
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
                    $('#category').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#category').find('p.text-danger').remove();
                    if (res.success == true) {
                        $("select[name='company_id'").html('');
                        $.each(res.data, function(){
                            $("select[name='company_id'").append('<option value="'+ this.company_id +'">'+ this.company_name +'</option>')
                        })
                        $('#company_id').val('');
                        $('#company_name').val('');
                        $('#company_description').val('');
                        $('#comModel').find('input.form-control').removeClass('has-error').removeClass('has-success');
                        $('#comModel').find('p.text-danger').remove();
                        $('#comModel').modal('hide');
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

    $('#unit').submit(function (e) {
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
                    $('#unit').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#unit').find('p.text-danger').remove();
                    if (res.success == true) {
                        $("select[name='unit_id'").html('');
                        $.each(res.data, function(){
                            $("select[name='unit_id'").append('<option value="'+ this.unit_id +'">'+ this.unit_name +'</option>')
                        })
                        $('#unit_id').val('');
                        $('#unit_name').val('');
                        $('#unitModel').find('input.form-control').removeClass('has-error').removeClass('has-success');
                        $('#unitModel').find('p.text-danger').remove();
                        $('#unitModel').modal('hide');
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
        var product_id = $(this).attr('product_id');
        $.ajax({
            url: base_url+'product/find',
            method: 'post',
            data: {product_id:product_id},
            dataType: 'json',
            success: function (res){
                $('#productedit .product_id').val(res.product_id);
                $('#productedit .product_name').val(res.product_name);
                $('#productedit .catagory_id').val(res.catagory_id);
                $('#productedit .product_model').val(res.product_model);
                $('#productedit .company_id').val(res.company_id);
                $('#productedit .product_size').val(res.product_size);
                $('#productedit .unit_id').val(res.unit_id);
            }
        });
    });

    $('#productedit').submit(function (e){
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
                    $('#productedit').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#productedit').find('p.text-danger').remove();
                    if (res.success == true) {
                        var file_data = $('#file1').prop('files')[0];
                        var form_data = new FormData();
                        form_data.append('file', file_data);
                        console.log(form_data)
                        $.ajax({
                            url: base_url+'product/upload_file/'+res.id, // point to server-side controller method
                            dataType: 'text', // what to expect back from the server
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,
                            type: 'post',
                            success: function (response) {
                                console.log(response)
                                $('#msg').html(response); // display success response from the server
                            },
                            error: function (response) {
                                $('#msg').html(response); // display error response from the server
                            }
                        });
                        $('#product')[0].reset();
                        swal({
                            title: "Good job!",
                            text: "Product Update successfully!",
                            icon: "success",
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                }else {
                    $.each(res.errors, function (key, value){
                        var el = $('.abc'+key);
                        el.removeClass('has-error').addClass(value.length > 0 ? 'has-error':'has-success').siblings('p.text-danger').remove();
                        el.after(value);
                    });
                }
            }
        });
    });
});

function edValueKeyPress()
{   
    var proid = $(".barcode_id1").val();
    var name=$('#edValue').val();
    var length=name.length;
    var max=894767687;
    var number=  Math.random() * (+max - +length) + +length;
    $(".barcode_id").val(proid+parseInt(number)); 
}

$(document).ready(function()
{
    $("#product_specification").change(function()
    { 
        var value = $(this).val();
        if(value ==2)
        {
            $(".war_peri").show();
            $(".barcode").hide();
        }
        else
        {
            $(".war_peri").hide();
            $(".barcode").show();
        }
        
    });
});
