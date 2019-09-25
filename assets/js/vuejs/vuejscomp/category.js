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
	        url: this.base_url+'category/all/'+this.pagno,
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
		        url: this.base_url+'category/all/'+pageno,
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

// category_form
$(document).ready(function () {
    $('#category').submit(function (e) {
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
                        $('#category')[0].reset();
                        swal({
                            title: "Good job!",
                            text: "Category Created successfully!",
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
        var catagory_id = $(this).attr('catagory_id');
        $.ajax({
            url: base_url+'category/find',
            method: 'post',
            data: {catagory_id:catagory_id},
            dataType: 'json',
            success: function (res){
                $('.catagory_id').val(res.catagory_id);
                $('.catagory_name').val(res.catagory_name);
                $('.catagory_description').val(res.catagory_description);
            }
        });
    });

    $('#categoryupdate').submit(function (e){
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            method: 'post',
            data: data,
            dataType: 'json',
            success: function (res){
                if (res.check == true) {
                    $('#update_category').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#update_category').find('p.text-danger').remove();
                    if (res.success == true) {
                        $('#updateCategory').modal('hide');
                        swal({
                            title: "Good job!",
                            text: "Category updated successfully!",
                            icon: "success",
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                }else {
                    $.each(res.errors, function (key, value){
                        var el = $('#update_category #'+key);
                        el.removeClass('has-error').addClass(value.length > 0 ? 'has-error':'has-success').find('p.text-danger').remove();
                        el.append(value);
                    });
                }
            }
        });
    });
});
