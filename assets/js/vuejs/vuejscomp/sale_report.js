new Vue({
  el:"#vue_app",
  data:{
    alldata:[],
    invoice_id:0,
    customer_id:0,
    product_id:0,
    seller_id:0,
    start_date:0,
    end_date:0,
    amount:0,
    samount:0,
    company_id:0,
    category_id:0,
    saletype:2,
    isinvoice:0,
    quantity:0,
  },
  methods:{
    result(){
      this.start_date=($("#datepickerrr").val());
      this.end_date=($("#datepickerr").val());
      this.amount=0;
      this.samount=0;
      var self=this;
      alldata:[];
      $.ajax({
      url: base_url+'Report/all_sale_report_find',
      type: 'POST',
      dataType: 'json',
      data: {company_id:this.company_id,category_id:this.category_id,saletype:this.saletype,invoice_id:this.invoice_id,customer_id:this.customer_id,product_id:this.product_id,seller_id:this.seller_id,start_date:this.start_date,end_date:this.end_date},
      success: function(result) { 
        self.alldata=result;
          result.forEach( function(element, index) {
           self.amount=parseInt(self.amount)+parseInt(element.unit_buy_price*element.sale_quantity);  
           self.samount=parseInt(self.samount)+parseInt((element.actual_sale_price*element.sale_quantity));
           self.quantity=parseInt(self.quantity)+parseInt((element.sale_quantity));
          });

          if(self.saletype==1){
            self.isinvoice=1;
          }else{
            self.isinvoice=0;
          }
      }
    });
    }
  },
})