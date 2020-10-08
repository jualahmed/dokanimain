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
            url: this.base_url+'employee/all/'+this.pagno,
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
                url: this.base_url+'employee/all/'+pageno,
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

// employee_form
$(document).ready(function () {
    $('#employee').submit(function (e) {
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
                    $('#employee').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#employee').find('p.text-danger').remove();
                    if (res.success == true) {
                        $('#employee')[0].reset();
                        swal({
                            title: "Good job!",
                            text: "Employee Created successfully!",
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
        var employee_id = $(this).attr('employee_id');
        $.ajax({
            url: base_url+'employee/find',
            method: 'post',
            data: {employee_id:employee_id},
            dataType: 'json',
            success: function (res){
                console.log(res);
                $('#employee_id').val(res.employee_id);
                $('#employee_name').val(res.employee_name);
                $('#employee_address').val(res.employee_address);
                $('#employee_contact_no').val(res.employee_contact_no);
                $('#int_balance').val(res.int_balance);
                $('#employee_email').val(res.employee_email);
                $('#employee_type').val(res.employee_type);
            }
        });
    });

    $('#employeeupdate').submit(function (e){
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
                    $('#employeeupdate').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#employeeupdate').find('p.text-danger').remove();
                    if (res.success == true) {
                        $('#employeeupdate')[0].reset();
                        $('#employeeupdate').modal('hide');
                        swal({
                            title: "Good job!",
                            text: "Employee updated successfully!",
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
