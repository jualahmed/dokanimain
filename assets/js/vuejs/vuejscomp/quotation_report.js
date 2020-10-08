Vue.component('multiselect', window.VueMultiselect.default)
new Vue({
	el:"#vue_app",
	data:{
		alldata:[],
		quotation_id:0,
		base_url:base_url,
		seller_id:0,
		customer_id:0,
		start_date:0,
		end_date:0,
		loding:false,
		isLoading:false,
		xhr:'ToCancelPrevReq'
	},
	methods:{
		result(){
			this.start_date=($("#datepickerrr").val());
			this.end_date=($("#datepickerr").val());
			this.loding=!this.loding;
			var self=this;
			alldata:[];
			$.ajax({
				url: base_url+'Report/all_quotation_report_find',
				type: 'POST',
				dataType: 'json',
				data: {
					quotation_id:this.quotation_id,
					seller_id:this.seller_id,
					customer_id:this.customer_id,
					start_date:this.start_date,
					end_date:this.end_date
				},
				success: function(result) { 
					self.alldata=result;
					self.loding=!self.loding;
					self.alldata = result;
				}
			});
		},
		deleteQuotation(quotation_id) {
			this.loding = !this.loding;
			var self=this;
			$.ajax({
				url: base_url+'sale/deleteQuotation',
				type: 'POST',
				dataType: 'json',
				data: {
					quotation_id: quotation_id,
				},
				success: function(result) { 
					if(result) {
						self.loding=!self.loding;
						self.result();
					}
				}
			});
		}
	},
})