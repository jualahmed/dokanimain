jQuery(document).ready(function($) {
	$(document).on('click', '.edit', function (e){
        e.preventDefault();
        $('#EditModel').modal('show');
        var shop_id = $(this).attr('shop_id');
        $.ajax({
            url: base_url+'shop/findshop',
            method: 'post',
            data: {shop_id:shop_id},
            dataType: 'json',
            success: function (res){
            	$("#shop_name").val(res.shop_name);
            	$("#shop_id").val(res.shop_id);
            	$("#shop_contact").val(res.shop_contact);
            	$("#shop_address").val(res.shop_address);
            }
        });
    });

    $('#shopupdate').submit(function (e){
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
                    $('#shopupdate').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#shopupdate').find('p.text-danger').remove();
                    if (res.success == true) {
                    	var file_data = $('#logod').prop('files')[0];
                    	var file_data2 = $('#invoicelogo').prop('files')[0];
                        var form_data = new FormData();
                        form_data.append('logo', file_data);
                        form_data.append('invoicelogo', file_data2);
                        $.ajax({
                            url: base_url+'shop/upload_file/'+res.id, // point to server-side controller method
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
                                console.log(response)
                                $('#msg').html(response); // display error response from the server
                            }
                        });
                        $('#EditModel').modal('hide');
                        swal({
                            title: "Good job!",
                            text: "Shop updated successfully!",
                            icon: "success",
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                }else {
                    $.each(res.errors, function (key, value){
                        var el = $('#EditModel #'+key);
                        el.removeClass('has-error').addClass(value.length > 0 ? 'has-error':'has-success').find('p.text-danger').remove();
                        el.append(value);
                    });
                }
            }
        });
    });
});