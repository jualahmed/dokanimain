Vue.component('multiselect', window.VueMultiselect.default)
new Vue({
	el:"#vueapp",
	data:{
		selectproduct:[],
		product:[],
		base_url:base_url,
		alldata:[],
		stockqty:0,
		amount:0,
		catagory_id:0,
		type_wise:0,
		product_id:0,
		company_id:0,
		amount:0,
		samount:0,
		loding:false,
		isLoading: false,
		xhr:'ToCancelPrevReq'
	},
	methods:{
		asyncFind (query) {
			var self = this;
		    this.isLoading = true
			if(query.length>2){
				this.countries=[];
				var self=this;
				this.xhr = $.ajax({
					url: this.base_url+'product/query/'+query,
					beforeSend : function() {
						if(self.xhr != 'ToCancelPrevReq' && self.xhr.readyState < 4) {
							self.xhr.abort();
						}
					},
					success: function(re) {
						self.product=JSON.parse(re)
		      			self.isLoading=false
					},
					error: function(xhr, ajaxOptions, thrownError) {
						if(thrownError == 'abort' || thrownError == 'undefined') return;
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				})
			}
			self.isLoading = false
	    },
		stockreport(){
			var am=$("#lock77").val();
			if(am){
				this.amount=am;
			}
			alldata=[];
			var self=this;
			self.stockqty=0;
			self.loding=!self.loding;
			self.amount=0;
			self.samount=0;
		 $.ajax({
			url:  $('#form_2').attr('action'),
			type: "POST",
			dataType: 'json',
			data: {catagory_id:this.catagory_id,product_id:this.selectproduct.product_id,company_id:this.company_id,type_wise:this.type_wise,product_amount:this.amount},
			success: function(result) { 
				self.alldata=result;
				self.loding=!self.loding;
				result.forEach( function(element, index) {
				 self.stockqty=parseFloat(self.stockqty)+parseFloat(element.stock_amount);
				 self.amount=parseFloat(self.amount)+parseFloat((element.stock_amount*element.bulk_unit_buy_price));
				 self.samount=parseFloat(self.samount)+parseFloat((element.stock_amount*element.general_unit_sale_price));
				});
			}
		});
		}
	},
})