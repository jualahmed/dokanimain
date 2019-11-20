new Vue({
  el:"#vueapp",
  data:{
    base_url:base_url,
    alldata:[],
    stockqty:0,
    amount:0,
    catagory_id:0,
    product_id:0,
    company_id:0,
    type:0,
    amount:0,
    samount:0,
  },
  methods:{
    stockreport(){
      var am=$("#lock77").val();
      if(am){
        this.amount=am;
      }
      alldata=[];
      var self=this;
      self.stockqty=0;
      self.amount=0;
      self.samount=0;
     $.ajax({
      url:  $('#form_2').attr('action'),
      type: "POST",
      dataType: 'json',
      data: {catagory_id:this.catagory_id,product_id:this.product_id,company_id:this.company_id,type_wise:this.type_wise,product_amount:this.amount},
      success: function(result) { 
        self.alldata=result;
        result.forEach( function(element, index) {
         self.stockqty=parseInt(self.stockqty)+parseInt(element.stock_amount);
         self.amount=parseInt(self.amount)+parseInt((element.stock_amount*element.bulk_unit_buy_price));
         self.samount=parseInt(self.samount)+parseInt((element.stock_amount*element.general_unit_sale_price));
        });
      }
    });
    }
  }
})