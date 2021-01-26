Vue.component("multiselect", window.VueMultiselect.default);
new Vue({
  el: "#vuejsapp",
  data: {
    alldata: [],
    stockqty: 0,
    amount: 0,
    samount: 0,
    base_url: base_url,
    receipt: 0,
    product: null,
    category: 0,
    company: 0,
    distributor_id: 0,
    start_date: 0,
    end_date: 0,
    loding: false,

    products: []
  },
  methods: {
    asyncFind(query) {
      var self = this;
      this.loding = true;
      if (query.length > 2) {
        var self = this;
        this.xhr = $.ajax({
          url: this.base_url + "product/query",
          type: "POST",
          data: { query: query },
          success: function (re) {
            self.products = JSON.parse(re);
            self.loding = false;
          },
          error: function (xhr, ajaxOptions, thrownError) {
            if (thrownError == "abort" || thrownError == "undefined") return;
            alert(
              thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText
            );
          },
        });
      }
      self.loding = false;
    },
    purchase_report() {
      this.start_date = $("#datepickerrr").val();
      this.end_date = $("#datepickerr").val();
      var self = this;
      var product_id = this.product == null ? 0 : this.product.product_id;
      self.stockqty = 0;
      self.amount = 0;
      self.loding = !self.loding;
      self.samount = 0;
      this.alldata = [];
      $.ajax({
        url: $("#form_3").attr("action"),
        type: "post",
        dataType: "json",
        data: {
          receipt_id: this.receipt,
          product_id: product_id,
          catagory_id: this.category,
          company_id: this.company,
          distributor_id: this.distributor_id,
          start_date: this.start_date,
          end_date: this.end_date,
        },
        success: function (result) {
          self.alldata = result;
          self.loding = !self.loding;
          result.forEach(function (element, index) {
            self.stockqty =
              parseFloat(self.stockqty) + parseFloat(element.purchase_quantity);
            self.amount =
              parseFloat(self.amount) +
              parseFloat(element.purchase_quantity * element.unit_buy_price);
            self.samount =
              parseFloat(self.samount) +
              parseFloat(element.purchase_quantity * element.unit_buy_price);
          });
        },
      });
    },
    formatDate(date) {
      var d = new Date(date),
        month = "" + (d.getMonth() + 1),
        day = "" + d.getDate(),
        year = d.getFullYear();
      if (month.length < 2) month = "0" + month;
      if (day.length < 2) day = "0" + day;
      return [day, month, year].join("-");
    },
  },
});
