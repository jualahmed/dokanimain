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
	        url: this.base_url+'unit/all/'+this.pagno,
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
		        url: this.base_url+'unit/all/'+pageno,
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

// unit_form
$(document).ready(function () {
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
                        $('#unit')[0].reset();
                        swal({
                            title: "Good job!",
                            text: "unit Created successfully!",
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
        var unit_id = $(this).attr('unit_id');
        $.ajax({
            url: base_url+'unit/find',
            method: 'post',
            data: {unit_id:unit_id},
            dataType: 'json',
            success: function (res){
                console.log(res);
                $('#unit_id').val(res.unit_id);
                $('#unit_name').val(res.unit_name);
            }
        });
    });

    $('#unitupdate').submit(function (e){
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
                    $('#unitupdate').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#unitupdate').find('p.text-danger').remove();
                    if (res.success == true) {
                        $('#unitupdate')[0].reset();
                        $('#unitupdate').modal('hide');
                        swal({
                            title: "Good job!",
                            text: "unit updated successfully!",
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
