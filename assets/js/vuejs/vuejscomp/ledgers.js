$(document).ready(function(){
	$("#purpose_id").on("change",function(){
		var purpose_id = $(this).val();
		if(purpose_id == 3) 
		{
			$('#exp_type_label').hide();
			$('#exp_type_list').hide();
			$('#emp_label').hide();
			$('#emp_list').hide();
			$('#dist_label').show();
			$('#dist_list').show();
			$('#distributor_id').attr('required',true);
			$('#customer_id').attr('required',false);
			$('#service_provider_id').attr('required',false);
			$('#cust_label').hide();
			$('#cust_list').hide();
			$('#ser_label').hide();
			$('#ser_list').hide();
			$('#type_label').hide();
			$('#type_list').hide();
			$('#own_type_label').hide();
			$('#own_type_list').hide();
			$('#customer_id').val('');
			$('#customer_id').select2();
			$('#service_provider_id').val('');
			$('#service_provider_id').select2();
			$('#transfer_type').val('');
			$('#transfer_type').select2();
			$('#owner_transfer_type').val('');
			$('#owner_transfer_type').select2();
		} 
		else if(purpose_id == 1) 
		{
			$('#exp_type_label').hide();
			$('#exp_type_list').hide();
			$('#emp_label').hide();
			$('#emp_list').hide();
			$('#dist_label').hide();
			$('#dist_list').hide();
			$('#distributor_id').attr('required',false);
			$('#customer_id').attr('required',true);
			$('#service_provider_id').attr('required',false);
			$('#cust_label').show();
			$('#cust_list').show();
			$('#ser_label').hide();
			$('#ser_list').hide();
			$('#type_label').hide();
			$('#type_list').hide();
			$('#own_type_label').hide();
			$('#own_type_list').hide();
			$('#distributor_id').val('');
			$('#distributor_id').select2();
			$('#service_provider_id').val('');
			$('#service_provider_id').select2();
			$('#transfer_type').val('');
			$('#transfer_type').select2();
			$('#owner_transfer_type').val('');
			$('#owner_transfer_type').select2();
		} 
		else if(purpose_id == 2) 
		{
			$('#exp_type_label').show();
			$('#exp_type_list').show();
			$('#emp_label').show();
			$('#emp_list').show();
			$('#dist_label').hide();
			$('#dist_list').hide();
			
			$('#cust_label').hide();
			$('#cust_list').hide();
			$('#type_label').hide();
			$('#type_list').hide();
			$('#own_type_label').hide();
			$('#own_type_list').hide();
			$('#ser_label').show();
			$('#ser_list').show();
			$('#distributor_id').attr('required',false);
			$('#customer_id').attr('required',false);
			//$('#service_provider_id').attr('required',true);
			$('#customer_id').val('');
			$('#customer_id').select2();
			$('#distributor_id').val('');
			$('#distributor_id').select2();
			$('#transfer_type').val('');
			$('#transfer_type').select2();
			$('#owner_transfer_type').val('');
			$('#owner_transfer_type').select2();
			
		} 
		else if(purpose_id == 4) 
		{
			$('#exp_type_label').hide();
			$('#exp_type_list').hide();
			$('#emp_label').hide();
			$('#emp_list').hide();
			$('#dist_label').hide();
			$('#dist_list').hide();
			$('#cust_label').hide();
			$('#cust_list').hide();
			$('#ser_label').hide();
			$('#ser_list').hide();
			$('#type_label').show();
			$('#type_list').show();
			$('#distributor_id').attr('required',false);
			$('#customer_id').attr('required',false);
			$('#service_provider_id').attr('required',false);
			$('#own_type_label').hide();
			$('#own_type_list').hide();
			$('#customer_id').val('');
			$('#customer_id').select2();
			$('#distributor_id').val('');
			$('#distributor_id').select2();
			$('#service_provider_id').val('');
			$('#service_provider_id').select2();
			$('#owner_transfer_type').val('');
			$('#owner_transfer_type').select2();
		} 
		else if(purpose_id == 5) 
		{
			$('#exp_type_label').hide();
			$('#exp_type_list').hide();
			$('#emp_label').hide();
			$('#emp_list').hide();
			$('#dist_label').hide();
			$('#dist_list').hide();
			$('#cust_label').hide();
			$('#cust_list').hide();
			$('#ser_label').hide();
			$('#ser_list').hide();
			$('#type_label').hide();
			$('#type_list').hide();
			$('#own_type_label').show();
			$('#own_type_list').show();
			$('#distributor_id').attr('required',false);
			$('#customer_id').attr('required',false);
			$('#service_provider_id').attr('required',false);
			$('#customer_id').val('');
			$('#customer_id').select2();
			$('#distributor_id').val('');
			$('#distributor_id').select2();
			$('#service_provider_id').val('');
			$('#service_provider_id').select2();
			$('#transfer_type').val('');
			$('#transfer_type').select2();
		} 
	});
});


// var vuejsapp = new Vue({
// 	el:"#vuejsapp",
// 	data:{
// 		base_url:base_url,
// 		result:[],
// 		pagno:0,
// 		pagination:[],
//         row:0,
//         rowperpage:0,
//         total:0,
// 	},
// 	created(){
		
// 	},
// 	methods:{
// 		greetdd:function(pageno){
// 			this.result=[];
// 			this.pagination=[];
// 			var self = this;
// 		    $.ajax({
// 		        url: this.base_url+'category/all/'+pageno,
// 		        type: 'GET',
// 		        dataType: 'json',
// 		        success: function(result) {
//                         self.rowperpage=result.rowperpage;
//                     self.row=result.row;
// 		         	self.result.push(result.result);
// 		         	self.pagination.push(result.pagination);
// 		        }
// 		    });
// 		}
// 	}
// })
