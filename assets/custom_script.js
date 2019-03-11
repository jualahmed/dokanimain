//$(function(){
//    alert('hello');
//});

$(function(){
  $(".modal").draggable({
      handle: ".modal-header",
      opacity: 0.8,
      cursor: "move",
      scroll: false
  });
});


$(function(){
    $('#sv_room_typ_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
          $('#sv_room_typ_form')[0].reset();
          show_room_typ();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });

 });
 
 show_room_typ();
 
});


function show_room_typ(){
    var submiturl = $('.show_type').val();
    $.ajax({
        url: submiturl,
        type: 'post',
        data: $(this).serialize(),
        beforeSend: function () {
         $('#table_room_typ').html('<p align="center"><i class="fa fa-spinner fa-pulse fa-2x"></i></p>');
         },
        success:function(result){
          $('#table_room_typ').html(result);
           edi_room_type();
           del_room_typ();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
}


function edi_room_type(){
    /*$('#tableedite').editableTableWidget();*/
    
    $('.room_typ_edi').click(function(){
        var edi_key = $(this).val();
        var submiturl = $('.edi_show_type').val();
        $.ajax({
            url: submiturl+'/'+edi_key,
            type: 'post',
            dataType: 'json',
            success:function(result){
              $('#edi_room_typ_form [name=room_typ_name]').val(result.room_typ_name);
              $('#edi_room_typ_form [name=max_adults]').val(result.max_adults);
              $('#edi_room_typ_form [name=max_childs]').val(result.max_childs);
              $('#edi_room_typ_form [name=room_typ_id]').val(result.room_typ_id);
              $('#show_room_type_modal').modal('show');
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
        
        
    });
}



$(function(){
    $('#edi_room_typ_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
          $('#edi_room_typ_form')[0].reset();
          show_room_typ();
          $('#show_room_type_modal').modal('hide');
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });

 });
 
});


function del_room_typ(){
     $('.room_typ_del').click(function(){
        var del_key = $(this).val();
        var submiturl = $('.del_type').val();
        bootbox.confirm("Are you sure delete this room type?", function(action) {
        if(action)
        $.ajax({
            url: submiturl+'/'+del_key,
            type: 'post',
            success:function(result){
              if(result == 1)
              show_room_typ();
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
        
        }); 
        
    });
}



$(function(){
    $('#sv_room_cls_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
          $('#sv_room_cls_form')[0].reset();
          show_room_cls();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });

 });
 
 show_room_cls();
 
});

function show_room_cls(){
    var submiturl = $('.show_class').val();
    $.ajax({
        url: submiturl,
        type: 'post',
        data: $(this).serialize(),
        beforeSend: function () {
         $('#table_room_cls').html('<p align="center"><i class="fa fa-spinner fa-pulse fa-2x"></i></p>');
         },
        success:function(result){
          $('#table_room_cls').html(result);
          edi_room_cls();
          del_room_cls();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
}



function edi_room_cls(){
    $('.room_cls_edi').click(function(){
        var edi_key = $(this).val();
        var submiturl = $('.edi_show_class').val();
        $.ajax({
            url: submiturl+'/'+edi_key,
            type: 'post',
            dataType: 'json',
            success:function(result){
             $('#edi_room_cls_form [name=class_name]').val(result.class_name);
              $('#edi_room_cls_form [name=class_id]').val(result.class_id);
              $('#show_room_cls_modal').modal('show');
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
        
        
    });
}


$(function(){
    $('#edi_room_cls_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
          $('#edi_room_cls_form')[0].reset();
          show_room_cls();
          $('#show_room_cls_modal').modal('hide');
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });

 });
 
});


function del_room_cls(){
     $('.room_cls_del').click(function(){
        var del_key = $(this).val();
        var submiturl = $('.del_class').val();
        bootbox.confirm("Are you sure delete this room class?", function(action) {
        if(action)
        $.ajax({
            url: submiturl+'/'+del_key,
            type: 'post',
            success:function(result){
              if(result == 1)
              show_room_cls();
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
        
        }); 
        
    });
}

$(function(){
    $('#room_number_sv_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
            show_rooms();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
 });
 
 show_rooms();
 
});


$(function(){
 $('#room_number_sv_form [name=room_typ_id], #room_number_sv_form [name=class_id]').on('change', function(){
   show_rooms();
 });
});


function show_rooms(){
    var submiturl = $('.show_room_link').val();
    var room_typ = $('#room_number_sv_form [name=room_typ_id]').val();
    var room_class = $('#room_number_sv_form [name=class_id]').val();
    $.ajax({
        url: submiturl,
        type: 'post',
        data: {'typ':room_typ, 'cls': room_class},
        beforeSend: function () {
         $('#show_rooms').html('<p align="center"><i class="fa fa-spinner fa-pulse fa-2x"></i></p>');
         },
        success:function(result){
            $('#show_rooms').html(result);
            del_room();
            show_sv_tag_modal();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
}



function del_room(){
     $('.room_del').click(function(){
        var del_key = $(this).val();
        var submiturl = $('.del_room_link').val();
        bootbox.confirm("Are you sure delete this room?", function(action) {
        if(action)
        $.ajax({
            url: submiturl+'/'+del_key,
            type: 'post',
            success:function(result){
              if(result == 1)
              show_rooms();
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
        
        }); 
        
    });
}

function show_sv_tag_modal(){
    $('.room_tag').click(function(){
        $room_id = $(this).val();
        
       $('#room_tag_form [name=room_id]').val($room_id);
       
        $('#room_tag_modal').modal('show');
    });
    
}



$(function(){
    $('#room_tag_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
            show_rooms();
            $('#room_tag_modal').modal('hide');
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
 });
 
});


$(function(){
    show_block_room();
    show_normal_room();
});

function show_block_room(){
   var submiturl = $('.block_room_list_link').val();
    $.ajax({
        url: submiturl,
        type: 'post',
        data: $(this).serialize(),
        beforeSend: function () {
         $('.blocked_room').html('<p align="center"><i class="fa fa-spinner fa-pulse fa-2x"></i></p>');
         },
        success:function(result){
            $('.blocked_room').html(result);
            unblock_rooms();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
}


function show_normal_room(){
   var submiturl = $('.unblock_room_list_link').val();
    $.ajax({
        url: submiturl,
        type: 'post',
        data: $(this).serialize(),
         beforeSend: function () {
         $('.normal_room').html('<p align="center"><i class="fa fa-spinner fa-pulse fa-2x"></i></p>');
         },
        success:function(result){
            $('.normal_room').html(result);
            block_rooms();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
}



function block_rooms(){
    $('.room_blocked').click(function() {
        var checkedValues = $('.normal_room input:checkbox:checked').map(function() {
        return this.value;
         }).get();
         
         var submiturl = $('.room_block_link').val();
            $.ajax({
                url: submiturl,
                type: 'post',
                data: {'room_id':checkedValues},
                success:function(result){
                    show_normal_room();
                    show_block_room();
                 },
                error: function (jXHR, textStatus, errorThrown) {html("")}
            });
        
    });
    
}


function unblock_rooms(){
    $('.room_normal').click(function() {
        var checkedValues = $('.blocked_room input:checkbox:checked').map(function() {
        return this.value;
         }).get();
         
         var submiturl = $('.room_unblock_link').val();
            $.ajax({
                url: submiturl,
                type: 'post',
                data: {'room_id':checkedValues},
                success:function(result){
                    show_normal_room();
                    show_block_room();
                 },
                error: function (jXHR, textStatus, errorThrown) {html("")}
            });
        
    });
    
}


$(function(){
    $('#sv_seassion_from').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 2){
                bootbox.alert("Date range conjume by another date. Please try to enter another date range for setup seassion.");
            }else{
                show_seassion();
            }
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
 });
 show_seassion();
});



function show_seassion(){
    var submiturl = $('.show_seassion_link').val();
    $.ajax({
        url: submiturl,
        type: 'post',
        data: $(this).serialize(),
         beforeSend: function () {
         $('.show_all_seassion').html('<p align="center"><i class="fa fa-spinner fa-pulse fa-2x"></i></p>');
         },
        success:function(result){
            $('.show_all_seassion').html(result);
            del_seassion();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
}


function del_seassion(){
     $('.seassion_del').click(function(){
        var del_key = $(this).val();
        var submiturl = $('.del_seassion_link').val();
        bootbox.confirm("Are you sure delete this seassion offer?", function(action) {
        if(action)
        $.ajax({
            url: submiturl+'/'+del_key,
            type: 'post',
            success:function(result){
              if(result == 1)
              show_seassion();
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
        
        }); 
        
    });
}


$(function(){
    $('#sv_rate_typ_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
            show_rate_typ();
            $('#sv_rate_typ_form')[0].reset();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
 });
show_rate_typ();
});


function show_rate_typ(){
    var submiturl = $('.show_rate_typ_link').val();
    $.ajax({
        url: submiturl,
        type: 'post',
        data: $(this).serialize(),
         beforeSend: function () {
         $('.show_rate_type').html('<p align="center"><i class="fa fa-spinner fa-pulse fa-2x"></i></p>');
         },
        success:function(result){
            $('.show_rate_type').html(result);
            del_rate_type();
            edi_rate_type_show();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
}


function edi_rate_type_show(){
    $('.rate_typ_edi').click(function(){
        var edi_key = $(this).val();
        var submiturl = $('.edi_rate_typ_show_link').val();
        $.ajax({
            url: submiturl+'/'+edi_key,
            type: 'post',
            dataType: 'json',
            success:function(result){
              $('#edi_rate_typ_form [name=rate_typ_name]').val(result.rate_typ_name);
              $('#edi_rate_typ_form [name=rate_typ_id]').val(result.rate_typ_id);
              $('#show_rate_typ_modal').modal('show');
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
        
    });
}



$(function(){
    $('#edi_rate_typ_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
            show_rate_typ();
            $('#edi_rate_typ_form')[0].reset();
            $('#show_rate_typ_modal').modal('hide');
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
 });
});



function del_rate_type(){
     $('.rate_typ_del').click(function(){
        var del_key = $(this).val();
        var submiturl = $('.del_rate_typ_link').val();
        bootbox.confirm("Are you sure delete this rate type?", function(action) {
        if(action)
        $.ajax({
            url: submiturl+'/'+del_key,
            type: 'post',
            success:function(result){
              if(result == 1)
              show_rate_typ();
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
        
        }); 
        
    });
}



$(function(){
    show_table_data();
    $('.general_rate_type').change(function(){
        show_table_data();
    });
});


function show_table_data(){
    var submiturl = $('.show_rate_link').val();
    var general_rate_type = $('.general_rate_type').val();
    $.ajax({
            url: submiturl,
            type: 'post',
            data: {'rate_type_id': general_rate_type},
            beforeSend: function () {
             $('.main_content_rate').html('<br><p align="center" style="width:800px"><i class="fa fa-spinner fa-pulse fa-2x"></i></p>');
             },
            success:function(result){
              $('.main_content_rate').html(result);
              show_regular_rate_modal();
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
}

function show_regular_rate_modal(){
    $('.set_rate').click(function(){
        $('#rate_amount_setup_form [name=all_id]').val($(this).val());
        $('#regular_rate_setup_modal').modal('show');
    });
}




$(function(){
    $('#rate_amount_setup_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
            $('#rate_amount_setup_form')[0].reset();
            $('#regular_rate_setup_modal').modal('hide');
            show_table_data();
            show_table_data_sesion();
            show_table_data_corporate();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
 });
});




$(function(){
    show_table_data_sesion();
    $('.seassion_rate_type').change(function(){
        show_table_data_sesion();
    });
});


function show_table_data_sesion(){
    var submiturl = $('.show_seassion_rate_link').val();
    var seassion_rate_type = $('.seassion_rate_type').val();
    $.ajax({
            url: submiturl,
            type: 'post',
            data: {'seassion_id': seassion_rate_type},
            beforeSend: function () {
             $('.main_content_rate_seassion').html('<br><p align="center" style="width:800px"><i class="fa fa-spinner fa-pulse fa-2x"></i></p>');
             },
            success:function(result){
              $('.main_content_rate_seassion').html(result);
              show_seassion_rate_modal();
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
}


function show_seassion_rate_modal(){
    $('.set_seassion_rate').click(function(){
        $('#rate_amount_setup_form [name=all_id]').val($(this).val());
        $('#regular_rate_setup_modal').modal('show');
    });
}




$(function(){
    show_table_data_corporate();
    $('.corporate_rate_type').change(function(){
        show_table_data_corporate();
    });
});


function show_table_data_corporate(){
    var submiturl = $('.show_corporate_rate_link').val();
    var corporate_rate_type = $('.corporate_rate_type').val();
    $.ajax({
            url: submiturl,
            type: 'post',
            data: {'corpID': corporate_rate_type},
            beforeSend: function () {
             $('.main_content_rate_corporate').html('<br><p align="center" style="width:800px"><i class="fa fa-spinner fa-pulse fa-2x"></i></p>');
             },
            success:function(result){
              $('.main_content_rate_corporate').html(result);
                show_corporate_rate_modal();
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
}



function show_corporate_rate_modal(){
    $('.set_corporate_rate').click(function(){
        $('#rate_amount_setup_form [name=all_id]').val($(this).val());
        $('#regular_rate_setup_modal').modal('show');
    });
}


$(function(){
    $('#sv_service_typ_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
          $('#sv_service_typ_form')[0].reset();
          show_service_typ();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });

 });
 
 show_service_typ();
 
});



function show_service_typ(){
    var submiturl = $('.show_service_typ_link').val();
    $.ajax({
        url: submiturl,
        type: 'post',
        data: $(this).serialize(),
        beforeSend: function () {
         $('#table_service_typ').html('<p align="center"><i class="fa fa-spinner fa-pulse fa-2x"></i></p>');
         },
        success:function(result){
          $('#table_service_typ').html(result);
          edi_service_typ();
          del_service_typ();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
}


function edi_service_typ(){
    $('.service_typ_edi').click(function(){
        var edi_key = $(this).val();
        var submiturl = $('.edi_service_typ_link').val();
        $.ajax({
            url: submiturl+'/'+edi_key,
            type: 'post',
            dataType: 'json',
            success:function(result){
             $('#edi_service_typ_form [name=service_typ_name]').val(result.service_typ_name);
              $('#edi_service_typ_form [name=service_typ_id]').val(result.service_typ_id);
              $('#show_service_typ_modal').modal('show');
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
        
        
    });
}


$(function(){
    $('#edi_service_typ_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
          $('#edi_service_typ_form')[0].reset();
          show_service_typ();
          $('#show_service_typ_modal').modal('hide');
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });

 });
 
});

function del_service_typ(){
     $('.service_typ_del').click(function(){
        var del_key = $(this).val();
        var submiturl = $('.del_service_typ_link').val();
        bootbox.confirm("Are you sure delete this service type?", function(action) {
        if(action)
        $.ajax({
            url: submiturl+'/'+del_key,
            type: 'post',
            success:function(result){
              if(result == 1)
              show_service_typ();
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
        
        }); 
        
    });
}


$(function(){
    $('#sv_service_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
          $('#sv_service_form')[0].reset();
          show_service();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });

 });
 
 show_service();
 
});

function show_service(){
    var submiturl = $('.show_service_link').val();
    $.ajax({
        url: submiturl,
        type: 'post',
        data: $(this).serialize(),
        beforeSend: function () {
         $('#table_service').html('<p align="center"><i class="fa fa-spinner fa-pulse fa-2x"></i></p>');
         },
        success:function(result){
          $('#table_service').html(result);
          edi_service();
          del_service();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
}


function edi_service(){
    $('.service_edi').click(function(){
        var edi_key = $(this).val();
        var submiturl = $('.edi_service_link').val();
        $.ajax({
            url: submiturl+'/'+edi_key,
            type: 'post',
            dataType: 'json',
            success:function(result){
              $('#edi_service_form [name=service_name]').val(result.service_name);
              $('#edi_service_form [name=service_id]').val(result.service_id);
              $('#edi_service_form [name=service_rate]').val(result.service_rate);
              $('#show_service_modal').modal('show');
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
    });
}


$(function(){
    $('#edi_service_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
          $('#edi_service_form')[0].reset();
          show_service();
          $('#show_service_modal').modal('hide');
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });

 });
 
});



function del_service(){
     $('.service_del').click(function(){
        var del_key = $(this).val();
        var submiturl = $('.del_service_link').val();
        bootbox.confirm("Are you sure delete this service?", function(action) {
        if(action)
        $.ajax({
            url: submiturl+'/'+del_key,
            type: 'post',
            success:function(result){
              if(result == 1)
              show_service();
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
        
        }); 
        
    });
}


$(function(){
    $('#extra_service_sv_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
          $('#extra_service_sv_form')[0].reset();
          show_extra_service();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });

 });
  show_extra_service();
});




function show_extra_service(){
    var submiturl = $('.show_extra_service_link').val();
    $.ajax({
        url: submiturl,
        type: 'post',
        data: $(this).serialize(),
        beforeSend: function () {
         $('#table_extra_service').html('<p align="center"><i class="fa fa-spinner fa-pulse fa-2x"></i></p>');
         },
        success:function(result){
          $('#table_extra_service').html(result);
          edi_extra_service_show();
          del_extra_service();
          
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
}


function edi_extra_service_show(){
    $('.extra_service_edi').click(function(){
        var edi_key = $(this).val();
        var submiturl = $('.edi_extra_service_link').val();
        $.ajax({
            url: submiturl+'/'+edi_key,
            type: 'post',
            dataType: 'json',
            success:function(result){
              $('#edi_extra_service_form [name=extra_service_name]').val(result.extra_service_name);
              $('#edi_extra_service_form [name=extra_service_id]').val(result.extra_service_id);
              $('#show_edi_extra_service_modal').modal('show');
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
    });
}


$(function(){
    $('#edi_extra_service_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
          $('#edi_extra_service_form')[0].reset();
          show_extra_service();
          $('#show_edi_extra_service_modal').modal('hide');
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });

 });
 
});


function del_extra_service(){
     $('.extra_service_del').click(function(){
        var del_key = $(this).val();
        var submiturl = $('.del_extra_service_link').val();
        bootbox.confirm("Are you sure delete this Extra service Charge?", function(action) {
        if(action)
        $.ajax({
            url: submiturl+'/'+del_key,
            type: 'post',
            success:function(result){
              if(result == 1)
              show_extra_service();
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
        
        }); 
        
    });
}



$(function(){
    $('#sv_new_agent_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
          $('#sv_new_agent_form')[0].reset();
          show_agent();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });

 });
 show_agent();
});

$(function(){
 $('.search').bind('change keyup', function(){
    show_agent();
 });

});


function show_agent(){
    var submiturl = $('.show_agent_link').val();
    var search = $('.search').val();
    
    $.ajax({
        url: submiturl,
        type: 'post',
        data: {'search':search},
        beforeSend: function () {
         $('#show_all_agent').html('<p align="center"><i class="fa fa-spinner fa-pulse fa-2x"></i></p>');
         },
        success:function(result){
          $('#show_all_agent').html(result);
          del_agent();
          edi_agent();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
}


function edi_agent(){
    $('.agent_edi').click(function(){
        var edi_key = $(this).val();
        var submiturl = $('.edi_agent_link').val();
        $.ajax({
            url: submiturl+'/'+edi_key,
            type: 'post',
            dataType: 'json',
            success:function(result){
              $('#sv_edi_agent_form [name=agent_name]').val(result.agent_name);
              $('#sv_edi_agent_form [name=address]').val(result.address);
              $('#sv_edi_agent_form [name=contact_no]').val(result.contact_no);
              $('#sv_edi_agent_form [name=agent_id]').val(result.agent_id);
              $('#sv_edi_agent_form [name=comission]').val(result.comission);
              $('#edi_agent_modal').modal('show');
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
    });
}

$(function(){
    $('#sv_edi_agent_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
          $('#sv_edi_agent_form')[0].reset();
          show_agent();
          $('#edi_agent_modal').modal('hide');
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });

 });
 
});


function del_agent(){
     $('.agent_del').click(function(){
        var del_key = $(this).val();
        var submiturl = $('.del_agent_link').val();
        bootbox.confirm("Are you sure delete this Agent?", function(action) {
        if(action)
        $.ajax({
            url: submiturl+'/'+del_key,
            type: 'post',
            success:function(result){
              if(result == 1)
              show_agent();
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
        
        }); 
        
    });
}


$(function(){
    $('#sv_cashbox_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
          $('#sv_cashbox_form')[0].reset();
         show_cashbox();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });

 });
show_cashbox();
});



function show_cashbox(){
    var submiturl = $('.show_cashbox_link').val();
    
    $.ajax({
        url: submiturl,
        type: 'post',
        data: $(this).serialize(),
        beforeSend: function () {
         $('#table_cashbox').html('<p align="center"><i class="fa fa-spinner fa-pulse fa-2x"></i></p>');
         },
        success:function(result){
          $('#table_cashbox').html(result);
          del_cashbox();
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });
}



function del_cashbox(){
     $('.cashbox_del').click(function(){
        var del_key = $(this).val();
        var submiturl = $('.del_cashbox_link').val();
        bootbox.confirm("Are you sure delete this Cashbox?", function(action) {
        if(action)
        $.ajax({
            url: submiturl+'/'+del_key,
            type: 'post',
            success:function(result){
              if(result == 1)
              show_cashbox();
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
        
        }); 
    });
}



$(function(){
    $('#hotel_info_sv_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: new FormData(this),
        contentType: false,       
        cache: false,             
        processData:false, 
        success:function(result){
            if(result == 1)
          $('#hotel_info_sv_form')[0].reset();
          $('#hotel_info_modal').modal('hide');
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });

 });
});











$(function(){
    $('#sv_edi_tax_form').on('submit', function(a){
    a.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    $.ajax({
        url: submiturl,
        type: methods,
        data: $(this).serialize(),
        success:function(result){
            if(result == 1)
          $('#sv_edi_tax_form')[0].reset();
          show_tax();
          $('#edi_tax_modal').modal('hide');
         },
        error: function (jXHR, textStatus, errorThrown) {html("")}
    });

 });
 
});



function del_tax(){
     $('.tax_del').click(function(){
        var del_key = $(this).val();
        var submiturl = $('.del_tax_link').val();
        bootbox.confirm("Are you sure delete this Tax Type?", function(action) {
        if(action)
        $.ajax({
            url: submiturl+'/'+del_key,
            type: 'post',
            success:function(result){
              if(result == 1)
              show_tax();
             },
            error: function (jXHR, textStatus, errorThrown) {html("")}
        });
        
        }); 
    });
}






































$(function(){
    
$('#sv_seassion_from [name=start_date]').datepicker({
   dateFormat: "dd-mm-yy",
   onClose: function( selectedDate ) {$( '#sv_seassion_from [name=end_date]').datepicker( "option", "minDate", selectedDate );}
});
  
$('#sv_seassion_from [name=end_date]').datepicker({
   dateFormat: "dd-mm-yy",
   onClose: function( selectedDate ) {$( '#sv_seassion_from [name=start_date]' ).datepicker( "option", "maxDate", selectedDate );}
});  
    
});







/*date javascript start*/
$(function(){
setInterval(function(){
var d = new Date();

var h1 = d.getHours();
var m1 = d.getMinutes();
var s1 = d.getSeconds();
var da1 = d.getDate();
var mo1 = d.getMonth();
var ye = d.getFullYear();

var h = check_tim(h1);
var m = check_tim(m1);
var s = check_tim(s1);
var da = check_tim(da1);
var mo = get_monthname(mo1);

var ampm = h < 12 ? "AM" : "PM";

var this_time=' '+h+':'+m+':'+s+' '+ampm;
var this_date=' '+da+' '+mo+' '+ye;

$('#system_time').html('<i class="fa fa-clock-o"></i> '+this_time);
$('#system_date').html('<i class="fa fa-calendar"></i> '+this_date);

}, 100);
});

function check_tim(v){
  if (v < 10) {
    return "0" + v;
}else{
  return v;
}

}


function get_monthname(i){
    switch (i){
        case 0:
            return 'Jan.';
            break;
        case 1:
            return 'Feb.';
            break;
        case 2:
            return 'Mar.';
            break;
        case 3:
            return 'Apr.';
            break;
        case 4:
            return 'May';
            break;
        case 5:
            return 'June';
            break;
        case 6:
            return 'July';
            break;
        case 7:
            return 'Aug.';
            break;
        case 8:
            return 'Sept.';
            break;
        case 9:
            return 'Oct.';
            break;
        case 10:
            return 'Nov.';
            break;
        case 11:
            return 'Dec.';
            break;
    }
}


























///////////////////////////////////////////////Kawsar Ahmed //////////////////////////////////

	function select_new_entry(table,id,class_name,field,valuess)
	{
			if(valuess!=''){
				var vlau = $('.'+valuess).val();
			}
			else{
				var vlau = '';
			}
			var submiturl = $('#ret_and_sel').val();
			var methods = 'GET';
			$.ajax({
				url: submiturl+'/'+table+'/'+id+'/'+field+'/'+vlau,
				alert(url);
				type: 'GET',
				success:function(result){
					var arr = result.split('","');
					var valu = arr[1].split('"]');
					$('.'+class_name).html(arr[0]);
					$('.'+class_name).val(valu[0]);
				},
				error: function (jXHR, textStatus, errorThrown) {html("")}
			});
	}

	function select_new_entry_with_id(table,id,class_name,field,valuess)
	{
			if(valuess!=''){
				var vlau = $('.'+valuess).val();
			}
			else{
				var vlau = '';
			}
			var submiturl = $('#ret_and_sel_with_id').val();
			var methods = 'GET';
			$.ajax({
				url: submiturl+'/'+table+'/'+id+'/'+field+'/'+vlau,
				type: 'GET',
				success:function(result){
					var arr = result.split('","');
					var valu = arr[1].split('"]');
					$('.'+class_name).html(arr[0]);
					$('.'+class_name).val(valu[0]);
				},
				error: function (jXHR, textStatus, errorThrown) {html("")}
			});
	}

	function select_purch_entry_with_id(table,id,class_name,sec_table,sec_id,sec_field)
	{
			var submiturl = $('#ret_and_sel_purch').val();
			var methods = 'GET';
			$.ajax({
				url: submiturl+'/'+table+'/'+id+'/'+sec_table+'/'+sec_id+'/'+sec_field,
				type: 'GET',
				success:function(result){
					var arr = result.split('","');
					var valu = arr[1].split('"]');
					$('.'+class_name).html(arr[0]);
					$('.'+class_name).val(valu[0]);
				},
				error: function (jXHR, textStatus, errorThrown) {html("")}
			});
	}







$(document).ready(function() {
    $('.add_category').click(function(){
		$('#show_rate_typ_modal').modal('show');
	});
	
	$('#add_category_form').on('submit', function(cate){
		cate.preventDefault();
		//alert('dfkjghsdkj');
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		
		$.ajax({
			url: submiturl,
			type: methods,
			data: $(this).serialize(),
			success:function(result){
				$('#show_rate_typ_modal').modal('hide');
				if(result == 'success'){
					alert('Data Successfully Saved.');
					select_new_entry('catagory_info','catagory_id','cetegor','catagory_name','');
				}
				else if(result == 'exist'){
					alert('Data Already Exists.');
					select_new_entry('catagory_info','catagory_id','cetegor','catagory_name','cate_name');
				}
				else if(result == 'error'){
					alert('Data Not Successfully Saved.');
				}
			 },
			error: function (jXHR, textStatus, errorThrown) {html("")}
		});
		
	});
});

$(document).ready(function() {
    $('.add_group').click(function(){
		$('#show_group_modal').modal('show');
	});
	
	$('#add_group_form').on('submit', function(grate){
		grate.preventDefault();
		//alert('dfkjghsdkj');
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		
		$.ajax({
			url: submiturl,
			type: methods,
			data: $(this).serialize(),
			success:function(result){
				$('#show_group_modal').modal('hide');
				if(result == 'success'){
					alert('Data Successfully Saved.');
					select_new_entry('group_info','group_id','group_name','group_name','');
				}
				else if(result == 'exist'){
					alert('Data Already Exists.');
					select_new_entry('group_info','group_id','group_name','group_name','grou_name');
				}
				else if(result == 'error'){
					alert('Data Not Successfully Saved.');
				}
			 },
			error: function (jXHR, textStatus, errorThrown) {html("")}
		});
		
	});
});


$(document).ready(function() {
    $('.add_company').click(function(){
		$('#add_company_modal').modal('show');
	});
	
	$('#add_company_form').on('submit', function(comp){
		comp.preventDefault();
		//alert('dfkjghsdkj');
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		
		$.ajax({
			url: submiturl,
			type: methods,
			data: $(this).serialize(),
			success:function(result){
				$('#add_company_modal').modal('hide');
				if(result == 'success'){
					alert('Data Successfully Saved.');
					select_new_entry('company_info','company_id','com_pany','company_name','');
					select_new_entry_with_id('distributor_info','distributor_id','distrib','distributor_name','');
				}
				else if(result == 'exist'){
					alert('Data Already Exists.');
					select_new_entry('company_info','company_id','com_pany','company_name','comp_name');
					select_new_entry_with_id('distributor_info','distributor_id','distrib','distributor_name','distt_name');
				}
				else{
					alert('Data Not Successfully Saved.');
				}
			 },
			error: function (jXHR, textStatus, errorThrown) {html("")}
		});
		
	});
	
	$('#add_distributor_form').on('submit', function(distr){
		distr.preventDefault();
		//alert('dfkjghsdkj');
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		
		$.ajax({
			url: submiturl,
			type: methods,
			data: $(this).serialize(),
			success:function(result){
				$('#add_distributor_modal').modal('hide');
				if(result == 'success'){
					alert('Data Successfully Saved.');
					select_new_entry_with_id('distributor_info','distributor_id','distrib','distributor_name','');
				}
				else if(result == 'exist'){
					alert('Data Already Exists.');
					select_new_entry_with_id('distributor_info','distributor_id','distrib','distributor_name','distt_name');
				}
				else if(result == 'error'){
					alert('Data Not Successfully Saved.');
				}
			 },
			error: function (jXHR, textStatus, errorThrown) {html("")}
		});
		
	});
	
	
	$('#add_purchase_receipt_form').on('submit', function(pursch){
		pursch.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		
		$.ajax({
			url: submiturl,
			type: methods,
			data: $(this).serialize(),
			success:function(result){
				$('#add_company_modal').modal('hide');
				$('.purchase_receipt_modal').modal('hide');
				if(result == 'success'){
					alert('Data Successfully Saved.');
					select_purch_entry_with_id('purchase_receipt_info','receipt_id','purchases_id','distributor_info','distributor_id','distributor_name');
				}
				else if(result == 'error'){
					alert('Data Not Successfully Saved.');
				}
			 },
			error: function (jXHR, textStatus, errorThrown) {html("")}
		});
		
	});
	
});

$(document).ready(function() {
    $('.purchase_receipt_ids').click(function(){
		$('.purchase_receipt_modal').modal('show');
	});
});

$(document).ready(function() {
    $('.add_distrbutor').click(function(){
		$('.add_distributor_modal').modal('show');
	});
});


$(document).ready(function() {
    $('.add_unit').click(function(){
		$('#show_unit_typ_modal').modal('show');
	});
	
	$('#add_unit_form').on('submit', function(uomp){
		uomp.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		
		$.ajax({
			url: submiturl,
			type: methods,
			data: $(this).serialize(),
			success:function(result){
				$('#show_unit_typ_modal').modal('hide');
				if(result == 'success'){
					alert('Data Successfully Saved.');
					select_new_entry('unit_info','unit_id','unit_name','unit_name','');
				}
				else if(result == 'exist'){
					alert('Data Already Exists.');
					select_new_entry('unit_info','unit_id','unit_name','unit_name','uni_name');
				}
				else{
					alert('Data Not Successfully Saved.');
				}
			 },
			error: function (jXHR, textStatus, errorThrown) {html("")}
		});
		
	});
	
	
	$('#specific_date_stck_from').on('submit', function(uompx){
		uompx.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		var date = $('#demo3').val();
		window.location = submiturl+'/'+date+'/'+date+'/0';
		
	});
	
	$('#duration_dte_form').on('submit', function(xompx){
		xompx.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		var date1 = $('#demo4').val();
		var date2 = $('#demo5').val();
		window.location = submiturl+'/'+date1+'/'+date2+'/0';
		
	});
});

$(document).ready(function() {
    $('#login_another').click(function(xdfgdf){
		xdfgdf.preventDefault();
		//alert('dfgdfs');
		$('#show_login_modal').modal('show');
	});
	
	$('#another_login_form').on('submit', function(anthf){
		anthf.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		
		$.ajax({
			url: submiturl,
			type: methods,
			data: $(this).serialize(),
			success:function(result){
				//$('#show_unit_typ_modal').modal('hide');
				//alert(result);
				if(result == '1'){
					location.reload();
				}
				else if(result == '3'){
					$('#mssage_log').text('Wrong Username Or Password.');
				}
				else{
					$('#mssage_log').text('Form Validation Error.');
				}
			 },
			error: function (jXHR, textStatus, errorThrown) {html("")}
		});
		
	});
});

/* $(document).ready(function() {
    $('.edit_quantty').click(function(){
		
		var edit_id = $(this).attr('id');
		
		var kval = edit_id.substring(7, 10);
		var quantity = $('#quantti_id'+kval).val();
		var temp_details_id = $('#details_id'+kval).val();
		//alert(quantity+'//'+temp_details_id);
		$('.uni_name').val(quantity);
		$('#temp_details_modal').val(temp_details_id);
		$('#show_quantty_modal').modal('show');
	});
	
 	$('#change_quanttyy_form').on('submit', function(uxchomp){
		uxchomp.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		
		$.ajax({
			url: submiturl,
			type: methods,
			data: $(this).serialize(),
			success:function(result){
				$('#show_unit_typ_modal').modal('hide');
				if(result == 'success'){
					alert('Data Successfully Saved.');
					select_new_entry('unit_info','unit_id','unit_name','unit_name','');
				}
				else if(result == 'exist'){
					alert('Data Already Exists.');
					select_new_entry('unit_info','unit_id','unit_name','unit_name','uni_name');
				}
				else{
					alert('Data Not Successfully Saved.');
				}
			 },
			error: function (jXHR, textStatus, errorThrown) {html("")}
		});
		
	}); 
});*/



jQuery.fn.putCursorAtEnd = function() {

  return this.each(function() {

    $(this).focus()

    // If this function exists...
    if (this.setSelectionRange) {
      // ... then use it (Doesn't work in IE)

      // Double the length because Opera is inconsistent about whether a carriage return is one character or two. Sigh.
      var len = $(this).val().length * 2;

      this.setSelectionRange(len, len);
    
    } else {
    // ... otherwise replace the contents with itself
    // (Doesn't work in Google Chrome)

      $(this).val($(this).val());
      
    }

    // Scroll to the bottom, in case we're in a tall textarea
    // (Necessary for Firefox and Google Chrome)
    this.scrollTop = 999999;

  });

};


////////////////////////////////////////////Kawsar Ahmed /////////////////////////////////////
