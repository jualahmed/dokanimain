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
	        url: this.base_url+'distributor/all/'+this.pagno,
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
		        url: this.base_url+'distributor/all/'+pageno,
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

// distributor_form
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
                        swal({
                            title: "Good job!",
                            text: "Distributor Created successfully!",
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
        var distributor_id = $(this).attr('distributor_id');
        $.ajax({
            url: base_url+'distributor/find',
            method: 'post',
            data: {distributor_id:distributor_id},
            dataType: 'json',
            success: function (res){
                console.log(res);
                $('#distributor_id').val(res.distributor_id);
                $('#distributor_name').val(res.distributor_name);
                $('#distributor_address').val(res.distributor_address);
                $('#distributor_contact_no').val(res.distributor_contact_no);
                $('#int_balance').val(res.int_balance);
                $('#distributor_email').val(res.distributor_email);
                $('#distributor_description').val(res.distributor_description);
            }
        });
    });

    $('#distributorupdate').submit(function (e){
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
                    $('#distributorupdate').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#distributorupdate').find('p.text-danger').remove();
                    if (res.success == true) {
                        $('#distributorupdate')[0].reset();
                        $('#distributorupdate').modal('hide');
                        swal({
                            title: "Good job!",
                            text: "Distributor updated successfully!",
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
