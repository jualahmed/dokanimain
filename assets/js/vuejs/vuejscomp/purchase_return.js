$(document).ready(function() 
{
	$("#distributor_id").on("change",function()
	{
		var distributor_id = $(this).val();
		var submiturl 	= base_url+'purchase/purchase_return/'+distributor_id;
		window.open(submiturl,'_self');
	});

	$("#product_id").on("change",function()
	{
		var product_id = $(this).val();
		var distributor_id = $('#hide_dist').val();
		
		var submiturl 	= base_url+'purchase/purchase_return/'+distributor_id+'/'+product_id;
		
		window.open(submiturl,'_self');
	});
	
	$("#return_amount").keyup(function()
	{
		var length=$("#return_amount").val().length;
		if(length>=1)
		{
			$("#submit").prop("disabled", false);
		}
		else
		{
			$("#submit").prop("disabled", true);
		}
	});
	
	$('.delete_product').click(function(){
    var edit_id 		= $(this).attr('id');
	var kval 			= edit_id.substring(6,10000000000000000000000000000000);
	swal({
        title               : 'Are you sure?',
        text                : "You won't be able to revert this!",
        type                : 'warning',
        showCancelButton    : true,
        confirmButtonColor  : '#db8b0b',
        cancelButtonColor   : '#419641',
        confirmButtonText   : 'Yes',
        cancelButtonText    : 'No'
    }).then(function () {
        $.ajax({
            url     : base_url+'purchase/removeProduct',
            type    : "POST",
            cache   : false,
            data    : { prmp_id: kval},
            success : function(result){
				swal(
                  'Deleted!',
                  'Data Delete Successfully..!)',
                  'success'
                );
				//thisTr.remove();	
				location.reload();
            }

        });
    })
	});
});
// purchase return 
var stock_amount=$("#stock_amount").val();
jQuery(document).ready(function($) {
	$("#return_amount").keyup(function(event) {
		if(parseInt(event.target.value) > parseInt(stock_amount)){
			$("#d-block").css({
				display: 'none',
			});
			$("#d-nodedsd").css({
				display: 'block',
			});
		}else{
			$("#d-block").css({
				display: 'block',
			});
			$("#d-nodedsd").css({
				display: 'none',
			});
		}
	});
});

jQuery(document).ready(function($) {
	$("#dddddddddddddddddddd").submit(function(event) {
		setTimeout(function() {
			location.reload();
		}, 1000);
	});
});