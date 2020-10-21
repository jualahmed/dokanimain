Vue.component("multiselect", window.VueMultiselect.default);
new Vue({
  el: "#vue_app",
  data: {
    selectproduct: [],
    product: [],
    alldata: [],
    invoice_id: 0,
    customer_id: 0,
    base_url: base_url,
    product_id: 0,
    seller_id: 0,
    start_date: 0,
    end_date: 0,
    amount: 0,
    samount: 0,
    company_id: 0,
    category_id: 0,
    saletype: 2,
    isinvoice: 0,
    quantity: 0,
    loding: false,
    isLoading: false,
    xhr: "ToCancelPrevReq",
  },
  methods: {
    calculateDue(grand_total, total_paid) {
      grand_total = isNaN(parseFloat(grand_total))
        ? 0
        : parseFloat(grand_total).toFixed(2);
      total_paid = isNaN(parseFloat(total_paid))
        ? 0
        : parseFloat(total_paid).toFixed(2);

      return grand_total - total_paid;
    },
    asyncFind(query) {
      var self = this;
      var invoice_id = self.invoice_id;
      this.isLoading = true;
      if ((query.length > 2 && invoice_id == 0) || invoice_id != 0) {
        this.countries = [];
        var self = this;
        this.xhr = $.ajax({
          url: this.base_url + "product/query/" + query + "/" + invoice_id,
          beforeSend: function () {
            if (self.xhr != "ToCancelPrevReq" && self.xhr.readyState < 4) {
              self.xhr.abort();
            }
          },
          success: function (re) {
            self.product = JSON.parse(re);
            self.isLoading = false;
          },
          error: function (xhr, ajaxOptions, thrownError) {
            if (thrownError == "abort" || thrownError == "undefined") return;
            alert(
              thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText
            );
          },
        });
      }
      self.isLoading = false;
    },
    result() {
      this.start_date = $("#datepickerrr").val();
      this.end_date = $("#datepickerr").val();
      this.amount = 0;
      this.samount = 0;
      this.quantity = 0;
      this.loding = !this.loding;
      var self = this;
      alldata: [];
      $.ajax({
        url: base_url + "Report/all_sale_report_find",
        type: "POST",
        dataType: "json",
        data: {
          company_id: this.company_id,
          category_id: this.category_id,
          saletype: this.saletype,
          invoice_id: this.invoice_id,
          customer_id: this.customer_id,
          product_id: this.selectproduct.product_id,
          seller_id: this.seller_id,
          start_date: this.start_date,
          end_date: this.end_date,
        },
        success: function (result) {
          self.alldata = result;
          self.loding = !self.loding;
          console.log(result);
          result.forEach(function (element, index) {
            if (self.saletype == 2) {
              if (!isNaN(parseFloat(element.unit_buy_price)))
                self.amount =
                  parseFloat(self.amount) +
                  parseFloat(element.unit_buy_price * element.sale_quantity);
              if (!isNaN(parseFloat(element.actual_sale_price)))
                self.samount =
                  parseFloat(self.samount) +
                  parseFloat(element.actual_sale_price * element.sale_quantity);
              if (element.sale_quantity != null)
                self.quantity =
                  parseFloat(self.quantity) + parseFloat(element.sale_quantity);
            } else {
              if (!isNaN(parseFloat(element.unit_buy_price)))
                self.amount =
                  parseFloat(self.amount) + parseFloat(element.grand_total);
              if (!isNaN(parseFloat(element.actual_sale_price)))
                self.samount =
                  parseFloat(self.samount) + parseFloat(element.total_paid);
              if (element.sale_quantity != null)
                self.quantity =
                  parseFloat(self.quantity) +
                  parseFloat(element.sale_quantity);
            }
          });

          if (self.saletype == 1) {
            self.isinvoice = 1;
          } else {
            self.isinvoice = 0;
          }
        },
      });
    },
  },
});
