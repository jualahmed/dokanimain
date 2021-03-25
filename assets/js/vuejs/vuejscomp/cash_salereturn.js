function blinker() {
  $(".total_click").fadeOut(500);
  $(".total_click").fadeIn(500);
}
setInterval(blinker, 1000);
$(document).ready(function () {
  $("input[type='checkbox'].s1").click(function () {
    if ($(this).is(":checked")) {
      $(".s3").not(".s1").removeAttr("checked");
      var submiturl = base_url + "salereturn/cash_salereturn/cash/yes";

      window.open(submiturl, "_self");
    } else {
      $(".s3").removeAttr("checked");
    }
  });
  $("input[type='checkbox'].s3").click(function () {
    if ($(this).is(":checked")) {
      $(".s1").not(".s3").removeAttr("checked");
      var submiturl = base_url + "salereturn/cash_salereturn/productsale/yes";

      window.open(submiturl, "_self");
    } else {
      $(".s1").removeAttr("checked");
    }
  });

  $("#submit").prop("disabled", true);
  $("#invoice_id").on("change", function (ev) {
    ev.preventDefault();

    var invoice_id = $(this).val();
    var return_type = $("#return_type").val();
    var invo_type = $("#invo_type").val();
    var submiturl =
      base_url +
      "salereturn/cash_salereturn/" +
      return_type +
      "/" +
      invo_type +
      "/" +
      invoice_id;

    window.open(submiturl, "_self");
  });

  var invoice_id =  $("#invoice_id").val();
  var url = `${base_url}product/search_by_name`;
 if (invoice_id != undefined && invoice_id != '') {
	 url = `${base_url}product/search_by_invoice/${invoice_id}`;
 }
  initProduct(url);

  function initProduct(url) {
    $("#product_id").select2({
      ajax: {
        url: url,
        type: "POST",
        dataType: "JSON",
        data: function (params) {
          return {
            query: params.term,
          };
        },
        processResults: function (response) {
          return {
            results: response,
          };
        },
        cache: true,
      },
      allowClear: true,
    });
  }
  $("#product_id").on("change", function () {
    var product_id = $(this).val();
    var return_type = $("#return_type").val();
    var invo_type = $("#invo_type").val();
    var invoice_id = $("#in_id").val();
    if (invoice_id == "") {
      invoice_id = "null";
    } else {
      invoice_id = invoice_id;
    }
    var submiturl =
      base_url +
      "salereturn/cash_salereturn/" +
      return_type +
      "/" +
      invo_type +
      "/" +
      invoice_id +
      "/" +
      product_id;

    window.open(submiturl, "_self");
  });
  $("#return_amount").keyup(function () {
    var length = $("#return_amount").val().length;
    if (length >= 1) {
      $("#submit").prop("disabled", false);
    } else {
      $("#submit").prop("disabled", true);
    }
  });
  $(".delete_product").click(function () {
    var edit_id = $(this).attr("id");
    var kval = edit_id.substring(6, 10000000000000000000000000000000);
    swal({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#db8b0b",
      cancelButtonColor: "#419641",
      confirmButtonText: "Yes",
      cancelButtonText: "No",
    }).then(function () {
      $.ajax({
        url: base_url + "salereturn/removeProduct",
        type: "POST",
        cache: false,
        data: { srmp_id: kval },
        success: function (result) {
          swal("Deleted!", "Data Delete Successfully..!)", "success");
          //thisTr.remove();
          location.reload();
        },
      });
    });
  });
});
