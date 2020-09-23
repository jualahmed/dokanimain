Vue.component('v-select', VueSelect.VueSelect);
Vue.component('multiselect', window.VueMultiselect.default)
const vm = new Vue({
	el:"#vuejscom",
	data() {
		return {
			base_url:base_url,
			single_purchase:0,
			purchase_receipt_info:[],
			selected1: '',
			query: "",
			selected: "",
			selectedCountries: null,
			countries: [],
			isLoading: false,
			expiredate: this.dateformate(new Date()),
			tp_total:0,
			vat_total:0,
			quantity:null,
			
			old_unit_buy_price_purchase:null,

			total_buy_price:null,
			unit_buy_price_purchase:null,
			original_total_buy_price: 0,
			exclusive_sale_price:0,
			general_sale_price:null,

			purchase_info:[],
			allworrantyproduct:[],
			totalqty:0,
			unit_buy_price:0,
			original_unit_buy_price: 0,
			tunit_buy_price:0,
			xhr:'ToCancelPrevReq',
			errors: {}
		};
	},
	methods: {
		dateformate(date){
			var today =date;
			var dd = String(today.getDate()).padStart(2, '0');
			var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
			var yyyy = today.getFullYear();
			today = yyyy + '-' + mm + '-' + dd;
			return today;
		},
		removePurchaseItem(purchase_id) {
			var self = this;
			swal({
				title               : 'Are you sure?',
				text                : "You won't be able to revert this!",
				type                : 'warning',
				showCancelButton    : true,
				confirmButtonColor  : '#db8b0b',
				cancelButtonColor   : '#419641',
				cancelButtonText    : 'No',
				confirmButtonText   : 'Yes'
			}).then(function () {
				$.ajax({
					url: self.base_url+'purchaselisting/removePurchaseItem',
					type: 'POST',
					data: {
						purchase_id: purchase_id
					},
					dataType: 'json',
					success: function (res) {
						if (res.success) {
							self.updatepurchase_info();
							swal(
								'Deleted!',
								'Product has been deleted.',
								'success'
							);
						}
					}
				});
			})
		},
		submit(){
			var purchase_receipt_id=this.selected1.receipt_id;
			var self=this;
			this.totalqty=parseInt(this.totalqty)+parseInt(this.quantity);
			this.tunit_buy_price=parseFloat(this.tunit_buy_price)+parseFloat(this.total_buy_price);
			var flag = true;
			if (this.quantity == '' || isNaN(this.quantity) || parseInt(this.quantity) == 0) {
				flag =  false;
				this.errors.quantity = 'required';
			}
			if (this.total_buy_price == '' || isNaN(this.total_buy_price) || parseInt(this.total_buy_price) == 0) {
				flag =  false;
				this.errors.total_buy_price = 'required';
			}
			if (this.unit_buy_price_purchase == '' || isNaN(this.unit_buy_price_purchase) || parseInt(this.unit_buy_price_purchase) == 0) {
				flag =  false;
				this.errors.unit_buy_price_purchase = 'required';
			}
			if (this.exclusive_sale_price == '' || isNaN(this.exclusive_sale_price) || parseInt(this.exclusive_sale_price) == 0) {
				flag =  false;
				this.errors.exclusive_sale_price = 'required';
			}
			if (this.general_sale_price == '' || isNaN(this.general_sale_price) || parseInt(this.general_sale_price) == 0) {
				flag =  false;
				this.errors.general_sale_price = 'required';
			}
			
			if (flag) {
				this.errors = {};
				$.ajax({
					url: this.base_url+'purchaselisting/createlisting',
					type: 'POST',
					data: {
						allworrantyproduct:this.allworrantyproduct,
						purchase_receipt_id: purchase_receipt_id,
						product_id:this.selectedCountries.product_id,
						has_serial_no:this.selectedCountries.has_serial_no,
						expiredate:this.expiredate,
						tp_total:this.tp_total,
						vat_total:this.vat_total,
						quantity:this.quantity,
						total_buy_price:this.total_buy_price,
						unit_buy_price_purchase:this.unit_buy_price_purchase,
						exclusive_sale_price:this.exclusive_sale_price,
						general_sale_price:this.general_sale_price
					},
				})
				.done(function(re) {
					if(re=='exceed'){
						alert("Purchase Priced Exceed Not Allow")
					}else{
						var re = jQuery.parseJSON(re);
						var index = self.purchase_info[0].findIndex(function (purchase) {
							return purchase.purchase_id == re[0].purchase_id;
						});
						if (index != -1) {
							self.purchase_info[0][index] = re[0];
						}else {
							self.purchase_info[0].push(re[0]);
						}
						
						self.general_sale_price=0;
						self.exclusive_sale_price=0;
						self.unit_buy_price_purchase=0;
						self.total_buy_price=0;
						self.quantity=0;
					}
				})
				.fail(function() {
					console.log("error");
				});
			}
		},
		limitText (count) {
			return `and ${count} other countries`
		},
		selectaproduct(e){
			this.total_buy_price = e.bulk_unit_buy_price === null ? 0.00 : e.bulk_unit_buy_price;
			this.unit_buy_price_purchase = e.bulk_unit_buy_price === null ? 0.00 : e.bulk_unit_buy_price;
			this.old_unit_buy_price_purchase = e.bulk_unit_buy_price === null ? 0.00 : e.bulk_unit_buy_price;
			this.original_total_buy_price = e.bulk_unit_buy_price === null ? 0.00 : e.bulk_unit_buy_price;
			this.general_sale_price = e.bulk_unit_sale_price === null ? 0.00 : e.bulk_unit_sale_price;
			this.exclusive_sale_price = e.bulk_unit_sale_price === null ? 0.00 : e.bulk_unit_sale_price;
			this.quantity = '';
		},
		isReadyToCreate() {
			return (this.selectedCountries && 
				(this.selectedCountries.product_warranty == 0 || this.allworrantyproduct.length == this.quantity) && 
				this.selected1 && 
				this.selectedCountries.product_id && 
				this.quantity && 
				this.exclusive_sale_price && 
				this.general_sale_price);
		},
		asyncFind (query) {
			if(query.length>2){
				this.isLoading = true
				this.countries=[];
				var self=this;
				this.xhr = $.ajax({
					url: this.base_url+'/product/search',
					data: {query: query},
					beforeSend : function() {
						if(self.xhr != 'ToCancelPrevReq' && self.xhr.readyState < 4) {
							self.xhr.abort();
						}
					},
					success: function(re) {
						var re=jQuery.parseJSON(re);
						self.countries = re
						self.isLoading = false
					},
					error: function(xhr, ajaxOptions, thrownError) {
						if(thrownError == 'abort' || thrownError == 'undefined') return;
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				})
				self.isLoading = false
			}
		},
		clearAll () {
			this.selectedCountries = []
		},
		setSelected(){
			console.log("sdfdsf");
		},
		updatepurchase_info(){
			this.purchase_info=[];
			var self = this;
			if(this.selected1){
				var purchase_receipt_id=this.selected1.receipt_id;
			}
			$.ajax({
				url: base_url+'purchaselisting/allproductbelogntopurchase/'+purchase_receipt_id,
			})
			.done(function(re) {
				self.totalqty=0;
				self.tunit_buy_price=0;
				self.unit_buy_price=0;
				var re= jQuery.parseJSON(re);
				self.purchase_info.push(re);
				re.forEach( function(element, index) {
					self.totalqty= parseInt(self.totalqty) + parseInt(element.purchase_quantity);
					self.unit_buy_price= parseFloat(self.unit_buy_price) + parseFloat(element.unit_buy_price);
					self.tunit_buy_price= parseFloat(self.tunit_buy_price) + parseFloat(element.purchase_quantity*element.unit_buy_price);
				});
			})
			.fail(function() {
				console.log("error");
			})
		}
	},
	watch:{
		quantity: function (val) {
			if (val === '') {
				this.total_buy_price = '';
				this.unit_buy_price_purchase = '';
			}else {
				this.quantity=parseInt(val);
				if (!isNaN(this.quantity) && this.quantity != 0) {
					this.total_buy_price = this.quantity * parseFloat(this.old_unit_buy_price_purchase).toFixed(2);
					this.unit_buy_price_purchase = parseFloat(this.total_buy_price).toFixed(2) / this.quantity;
				}
			}
		},
		total_buy_price: function (val) {
			if (this.quantity !== '') {
				if (val === '') {
					this.unit_buy_price_purchase = '';
					this.quantity = '';
				}else {
					this.total_buy_price = parseFloat(val);
					if (!isNaN(this.quantity) && !isNaN(this.total_buy_price)) {
						this.unit_buy_price_purchase = parseFloat(this.total_buy_price).toFixed(2) / parseFloat(this.quantity).toFixed(2);
					}
				}
			} 
		},
		unit_buy_price_purchase: function (val) {
			if (this.quantity !== '') {
				if (val === '') {
					this.total_buy_price = '';
					this.quantity = '';
				}else {
					if (!isNaN(this.quantity)) {
						this.total_buy_price = this.quantity * val;
					}
				}
			}
		},
		selected1:function(val){
			this.purchase_info=[];
			var self = this;
			if(this.selected1){
				var purchase_receipt_id=this.selected1.receipt_id;
			}
			$.ajax({
				url: base_url+'purchaselisting/allproductbelogntopurchase/'+purchase_receipt_id,
			})
			.done(function(re) {
				self.totalqty=0;
				self.tunit_buy_price=0;
				self.unit_buy_price=0;
				var re= jQuery.parseJSON(re);
				self.purchase_info.push(re);
				re.forEach( function(element, index) {
					self.totalqty= parseInt(self.totalqty) + parseInt(element.purchase_quantity);
					self.unit_buy_price= parseFloat(self.unit_buy_price) + parseFloat(element.unit_buy_price);
					self.tunit_buy_price= parseFloat(self.tunit_buy_price) + parseFloat(element.purchase_quantity*element.unit_buy_price);
				});
			})
			.fail(function() {
				console.log("error");
			})
		}
	},
	created(){
		var self = this;
		$.ajax({
			url     : base_url+'purchase/alls',
			cash    : false,
			dataType: 'json',
			success : function(re)
			{	
				for (var i = re.length - 1; i >= 0; i--) {
					self.purchase_receipt_info.push(re[i]);
				}
			}
		});
	},
	computed: {
		 
	},
	filters: {
		custom_date(date) {
			return moment(date).format('DD-MM-YYYY');
		}
	}
});

$("#qty").keyup(function () {
	var quantity = $(this).val();
	if (quantity == '') {
		quantity = 1;
		$(this).val(quantity);
	}
});
function calculate(value) {
	var quantity = $("#qty").val();
	quantity = parseFloat(quantity);

	if (!isNaN(quantity)) {
		$("#u_b_p").val(value/quantity);
	}
}




// old js will delete soon
$(function () {
	$('#pro_serial_input_for_edit').on('click', "[name='edit_warran']", function(ev)
	{
		ev.preventDefault();
		var ip_id            		= $(this).attr('id');
		var product_type_name       = $('#product_type'+ip_id).val();	
			var submiturl = base_url+'purchase/update_product_warranty';
			var methods = 'POST';
			var output = '';
			var input_box='';
			var k=1;
			$.ajax(
			{
				url: submiturl,
				type: methods,
				dataType: 'JSON',
				data: {'ip_id':ip_id,'product_type_name':product_type_name},  	
				success:function(result)
				{
					swal(
						'Updated!',
						'Product has been updated.',
						'success'
						);
					$('#product_type'+ip_id).val(result.sl_no);
				}
			});
		});

	$('#pro_serial_input_for_edit').on('click', "[name='remove_warran']", function(){
			var ip_id            = $(this).attr('id');
			var purchase_receipt_id   = $('#pur_rec_id').val();
			var tr                    = $(this);
		var product_id     = parseInt($('#pro_hide').val());
		var pro_hide_buy     = parseInt($('#pro_hide_buy').val());
		//alert(ip_id);
		//alert(purchase_receipt_id);
	 // alert(product_id);
			if(ip_id != '' && purchase_receipt_id != '' && product_id != '')
		{
				swal({
						title               : 'Are you sure?',
						text                : "You won't be able to revert this!",
						type                : 'warning',
						showCancelButton    : true,
						confirmButtonColor  : '#db8b0b',
						cancelButtonColor   : '#419641',
						cancelButtonText    : 'No',
						confirmButtonText   : 'Yes'
					}).then(function () 
					{
				
							$.ajax({
								url       : base_url+"purchase/removeProductFromPurchase_warranty",
								type      : 'POST',
								cash      : false,
								data      : {purchase_receipt_id: purchase_receipt_id, ip_id: ip_id, product_id: product_id, pro_hide_buy: pro_hide_buy},
								success: function(result)
								{
					//alert(result);
					tr.closest('tr').remove();
					var total_final = 0.00;
					$('.total_purchase_price_final').each(function(){
						total_final += parseFloat($(this).text()); 
					});
					$('#total_purchase_price_new_final').html(total_final);
									swal(
										'Deleted!',
										'Product has been deleted.',
										'success'
									);
					
								}
							});
					})
			}

		});
	});


	/**
	 * New Product create form 
	 */
	$(document).ready(function () {
		$(window).keydown(function(event){
			if(event.keyCode == 13) {
			  event.preventDefault();
			  return false;
			}
		});
		$('#product_form').submit(function (e) {
			e.preventDefault();
			var data = $(this).serialize();
			var url = $(this).attr('action');
			$.ajax({
				url: url,
				method: 'POST',
				data: data,
				dataType: 'json',
				success: function (res){
					console.log(res)
					if (res.check == true) {
						$("#productModel").modal('hide');
						$('#product_form').find('div.form-group').removeClass('has-error').removeClass('has-success');
						$('#product_form').find('p.text-danger').remove();
						if (res.success == true) {
							vm.selectedCountries = res.product;
							vm.isReadyToCreate();
							var file_data = $('#file').prop('files')[0];
							var form_data = new FormData();
							form_data.append('file', file_data);
							$.ajax({
								url: base_url+'product/upload_file/'+res.id, // point to server-side controller method
								dataType: 'text', // what to expect back from the server
								cache: false,
								contentType: false,
								processData: false,
								data: form_data,
								type: 'post',
								success: function (response) {
									$('#msg').html(response); // display success response from the server
								},
								error: function (response) {
									$('#msg').html(response); // display error response from the server
								}
							});
							$('#product_form')[0].reset();
							swal({
								title: "Good job!",
								text: "Product Created successfully!"
							});

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
			
		
		 // fatch category without refresh page for outside category model
		$('#categoryinsertformproduct').submit(function (e) {
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
							$("select[name='catagory_id'").html('');
							$.each(res.data, function(){
								$("select[name='catagory_id'").append('<option value="'+ this.catagory_id +'">'+ this.catagory_name +'</option>')
							})
							$('#catagory_id').val('');
							$('#catagory_name').val('');
							$('#catagory_description').val('');
							$('#cModel').find('input.form-control').removeClass('has-error').removeClass('has-success');
							$('#cModel').find('p.text-danger').remove();
							$('#cModel').modal('hide');
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
	
		// fatch onpamy without refresh page for outside category model
		$('#conpamyinsertformproduct').submit(function (e) {
			e.preventDefault();
			var data = $(this).serialize();
			var url = $(this).attr('action');
			$.ajax({
				url: url,
				method: 'POST',
				data: data,
				dataType: 'json',
				success: function (res){
					console.log(res);
					if (res.check == true) {
						$('#category').find('div.form-group').removeClass('has-error').removeClass('has-success');
						$('#category').find('p.text-danger').remove();
						if (res.success == true) {
							$("select[name='company_id'").html('');
							$.each(res.data, function(){
								$("select[name='company_id'").append('<option value="'+ this.company_id +'">'+ this.company_name +'</option>')
							})
							$('#company_id').val('');
							$('#company_name').val('');
							$('#company_description').val('');
							$('#comModel').find('input.form-control').removeClass('has-error').removeClass('has-success');
							$('#comModel').find('p.text-danger').remove();
							$('#comModel').modal('hide');
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
							$("select[name='unit_id'").html('');
							$.each(res.data, function(){
								$("select[name='unit_id'").append('<option value="'+ this.unit_id +'">'+ this.unit_name +'</option>')
							})
							$('#unit_id').val('');
							$('#unit_name').val('');
							$('#unitModel').find('input.form-control').removeClass('has-error').removeClass('has-success');
							$('#unitModel').find('p.text-danger').remove();
							$('#unitModel').modal('hide');
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
	
		// This event clear barcode
		$('.clear_barcode').on('click', function () {
			$('.barcode_id').val('');
		});




		$('#purchase_products').on('click', "[name='edit']", function(ev)
		{
			ev.preventDefault();

			global_product_id                 	= $(this).attr('id');
			global_purchase_receipt_id       	= $('#pur_rec_id').val();
			var purchase_receipt_id       		= $('#purchase_receipt_id').val();
			selected_row                      	= $(this);
			var specification_id     			= $('#spec'+global_product_id).val();
			var old_qty     					= parseFloat(selected_row.closest('tr').find('td:nth-child(4)').text());
			var old_tp      					= parseFloat(selected_row.closest('tr').find('td:nth-child(5)').text());
			var product_id            = $(this).attr('id');
			var purchase_id            = $(this).attr('purchase_id');
			var purchase_receipt_id   = $('#pur_rec_id').val();
			console.log(product_id);
			$.ajax({
				url: base_url+'purchaselisting/find',
				type: 'POST',
				data: {purchaselisting_id: purchase_id},
			})
			.done(function(re) {
				var re= jQuery.parseJSON(re);
				$("#purchase_id").val(re.purchase_id);
				$("#qty").val(re.purchase_quantity);
				$("#qty_hidden").val(re.purchase_quantity);
				$("#u_b_p").val(re.unit_buy_price);
				$("#g_b_p").val(re.general_unit_sale_price);
				$("#e_b_p").val(re.bulk_unit_sale_price);

				if (re.has_serial_no && re.serials.length > 0) {
					var output = '';
					$.each(re.serials, function (key, serial) {
						output += `<li>
							<div class="input-group input-group-md">
								<input type="hidden" name="sp_id" value="${serial.sp_id}" id="sp_id"/>
								<input type="text" name="serial_no[]" value="${serial.sl_no}" id="serial_no" class="form-control">
								<div class="input-group-btn">
									<button class="btn btn-danger" type="button"><i class="fa fa-times"></i></button>
								</div>
							</div>
						</li>`;
					});
					$(".serial-no-list").html(output);
				}
			})
			.fail(function() {
				console.log("error");
			})
		});

		$("#edit_modal #qty").change(function () {
			var qty_hidden = $("#qty_hidden").val();
			$(".new-serial").remove();
			var new_qty = $(this).val();
			var dif =new_qty - qty_hidden;
			if (dif > 0) {
				while (dif > 0) {
					var output = `<li class="new-serial">
						<div class="input-group input-group-md">
							<input type="hidden" name="sp_id" value=""/>
							<input type="text" name="serial_no[]" value="" class="form-control">
							<div class="input-group-btn">
								<button class="btn btn-success" type="button"><i class="fa fa-check"></i></button>
							</div>
						</div>
					</li>`;
					$(".serial-no-list").append(output);
					dif--;
				}
			}
			if (dif < 0) {
				dif = dif * -1;
				alert(`Remove ${dif} serial no.`);
			}
		});
		$('#edit_modal_form').on('submit', function(ev){
			var serial_nos = $("input[name='serial_no[]']").map(function () {
				return $(this).val();
			}).get();
			console.log(serial_nos);
			ev.preventDefault();
			// var qty             = $('#qty').val();
			// var purchase_id             = $('#purchase_id').val();
			// var unit_buy_price  = $('#u_b_p').val();
			// var general_unit_sale_price  = $('#g_b_p').val();
			// var bulk_unit_sale_price  = $('#e_b_p').val();
			// if(qty != '' && qty > 0 && !isNaN(qty) && unit_buy_price !='' && unit_buy_price > 0 && !isNaN(unit_buy_price)){
			// 	swal({
			// 		title               : 'Are you sure?',
			// 		text                : ":)",
			// 		type                : 'warning',
			// 		showCancelButton    : true,
			// 		confirmButtonColor  : '#db8b0b',
			// 		cancelButtonColor   : '#419641',
			// 		confirmButtonText   : 'Yes',
			// 		cancelButtonText    : 'No'
			// 	}).then(function (){
			// 		$.ajax({
			// 		url       : base_url+'purchaselisting/editPruchaseProduct',
			// 		type      : 'POST',
			// 		data      : {
			// 						purchase_id           : purchase_id,
			// 						qty                   : qty, 
			// 						u_b_p                 : unit_buy_price,
			// 						e_b_p                 : bulk_unit_sale_price,
			// 						g_b_p                 : general_unit_sale_price,
			// 					},
			// 		success   : function(info)
			// 		{	
			// 			vm.updatepurchase_info();
			// 			console.log(info)
			// 			$('#edit_modal_form').trigger("reset");
			// 			$('#edit_modal').modal('hide');
			// 			var total_final = 0.00;
			// 			$('.total_purchase_price_final').each(function(){
			// 				total_final += parseFloat($(this).text()); 
			// 			});
			// 			$('#total_purchase_price_new_final').html(total_final);

			// 			swal(
			// 			'Edited!',
			// 			'Data has been edited.',
			// 			'success'
			// 			);
			// 		}
			// 		});
			// 	}, function (dismiss) {
			// 		if (dismiss === 'cancel') {
			// 		$('#edit_modal_form').trigger("reset");
			// 		$('#edit_modal').modal('hide');
			// 		swal(
			// 			'Canceled',
			// 			':)',
			// 			'info'
			// 		)
			// 		}
			// 	})
			// }
			// else{
			// $('#edit_modal_form').trigger("reset");
			// swal(
			// 	'Oops...!',
			// 	'Invalid Data!!!',
			// 	'error'
			// );
			// }
			/*swal*/
		});
	});

function edValueKeyPress()
{   
    var proid = $(".barcode_id1").val();
    var name=$('#edValue').val();
    var length=name.length;
    var max=894767687;
    var number=  Math.random() * (+max - +length) + +length;
    $(".barcode_id").val(proid+parseInt(number)); 
}