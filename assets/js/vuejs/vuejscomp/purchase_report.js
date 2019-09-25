new Vue({
  el:"#vuejsapp",
  data:{
    alldata:[],
    stockqty:0,
    amount:0,
    samount:0,
    base_url:base_url,
    receipt:0,
    product:0,
    category:0,
    company:0,
    distributor_id:0,
    start_date:0,
    end_date:0,
  },
  methods:{
    purchase_report(){
      this.start_date=($("#datepickerrr").val());
      this.end_date=($("#datepickerr").val());
      var self=this;
      self.stockqty=0;
      self.amount=0;
      self.samount=0;
      this.alldata=[]
        $.ajax({
        url:$('#form_3').attr('action'),
        type: "post",
        dataType: 'json',
        data: {receipt_id:this.receipt,product_id:this.product,catagory_id:this.category,company_id:this.company,distributor_id:this.distributor_id,start_date:this.start_date,end_date:this.end_date},
        success: function(result) { 
          self.alldata=result;
          result.forEach( function(element, index) {
           self.stockqty=parseInt(self.stockqty)+parseInt(1);
           self.amount=parseInt(self.amount)+parseInt((element.general_unit_sale_price));
           self.samount=parseInt(self.samount)+parseInt((element.purchase_price));
          });
        }
    });
    },
    formatDate(date) {
        var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        return [day,month,year].join('-');
    }
  }
})
