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
	        url: this.base_url+'company/all/'+this.pagno,
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
		        url: this.base_url+'company/all/'+pageno,
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

// company_form
$(document).ready(function () {
    $('#company').submit(function (e) {
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
                    $('#company').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#company').find('p.text-danger').remove();
                    if (res.success == true) {
                        $('#company')[0].reset();
                        swal({
                            title: "Good job!",
                            text: "Company Created successfully!",
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
        var company_id = $(this).attr('company_id');
        $.ajax({
            url: base_url+'company/find',
            method: 'post',
            data: {company_id:company_id},
            dataType: 'json',
            success: function (res){
                console.log(res);
                $('#company_id').val(res.company_id);
                $('#company_name').val(res.company_name);
                $('#company_address').val(res.company_address);
                $('#company_contact_no').val(res.company_contact_no);
                $('#company_email').val(res.company_email);
                $('#company_description').val(res.company_description);
            }
        });
    });

    $('#companyupdate').submit(function (e){
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
                    $('#companyupdate').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#companyupdate').find('p.text-danger').remove();
                    if (res.success == true) {
                        $('#companyupdate')[0].reset();
                        $('#companyupdate').modal('hide');
                        swal({
                            title: "Good job!",
                            text: "Company updated successfully!",
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
