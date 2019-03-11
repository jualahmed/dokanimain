//$(function(){
//    alert('hello');
//});


/*  */
$(document).ready(function() {
    $('.add_category').click(function(){
		$('#show_rate_typ_modal').modal('show');
	});
	
	$('#add_category_form').on('submit', function(cate){
		cate.preventDefault();
		cate.stopImmediatePropagation();
		//alert('dfkjghsdkj');
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		
		$.ajax({
			url: submiturl,
			type: methods,
			data: $(this).serialize(),
			success:function(result)
			{
				$('#show_rate_typ_modal').modal('hide');
				if(result == 'success'){
					alert('Data Successfully Saved.');
					select_new_entry('catagory_info','catagory_id','catagory_name','catagory_name','');
					$(".select22").select2();
				}
				else if(result == 'exist'){
					alert('Data Already Exists.');
					select_new_entry('catagory_info','catagory_id','catagory_name','catagory_name','cate_name');
					$(".select22").select2();
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
		comp.stopImmediatePropagation();
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
					select_new_entry('company_info','company_id','company_name','company_name','');
					$(".select33").select2();
				}
				else if(result == 'exist'){
					alert('Data Already Exists.');
					select_new_entry('company_info','company_id','company_name','company_name','comp_name');
					$(".select33").select2();
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
				$('#add_company_modal').modal('hide');
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
				$('#purchase_receipt_modal').modal('hide');
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
    $('.add_unit').click(function(){
		$('#show_unit_typ_modal').modal('show');
	});
	
	$('#add_unit_form').on('submit', function(uomp){
		uomp.preventDefault();
		uomp.stopImmediatePropagation();
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
					//selection_key();
					select_new_entry('unit_info','unit_id','unit_name','unit_name','');
					$(".select44").select2();
				}
				else if(result == 'exist'){
					alert('Data Already Exists.');
					//selection_key();
					select_new_entry('unit_info','unit_id','unit_name','unit_name','uni_name');
					$(".select44").select2();
				}
				else{
					alert('Data Not Successfully Saved.');
				}
			 },
			error: function (jXHR, textStatus, errorThrown) {html("")}
		});
		
	});
});


/* function selection_key(){
	$(".select4").select2();
	
} */



////////////////////////////////////////////Kawsar Ahmed /////////////////////////////////////







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
				type: 'GET',
				success:function(result){
					var arr = result.split('","');
					var valu = arr[1].split('"]');
					//alert('.'+class_name);
					$('.'+class_name).html(arr[0]);
					$('.'+class_name).val(valu[0]);
					//$('.'+class_name).text(valu[0]);
					//alert(arr[0]);
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