$('#purchase_amount').keyup(function()
 {
	var purchase_amount = $(this).val();
	var gift_on_purchase = $('#gift_on_purchase').val();
	if(isNaN(gift_on_purchase))
	{
		gift_on_purchase = 0;
	}
	else{
		gift_on_purchase = gift_on_purchase;
	}
	var avg_price = purchase_amount-gift_on_purchase;
	$('.grand_total').val(avg_price);
});
$('#gift_on_purchase').keyup(function()
{
	var gift_on_purchase = $(this).val();
	var purchase_amount = $('#purchase_amount').val();

	var avg_price = purchase_amount-gift_on_purchase;
	$('.grand_total').val(avg_price);
});

$(document).ready(function () 
{
	$('#receipt_id').on('change',function (evv) 
	{
		
		var receipt_id = $(this).val();
		var submiturl 	= base_url+'modify/total_purchase_price';
		window.open(submiturl+'/'+receipt_id);
	});
});