// product listing for indivisul sael
jQuery(document).ready(function ($) {
  $('[name="sale_btn"]').on("click", function () {
    $('[name="sale_btn"]').attr("disabled", true);
    $.ajax({
      url: base_url + "sale/addNewSale",
      type: "POST",
      cache: false,
      data: {},
      success: function (result) {
        location.reload();
      },
    });
  });

  $("#search_by_product_name").on("keyup", function (ev) {
    var is_sale_active = $("#is_sale_active").val();
    var allow_negative_stock = $("#allow_negative_stock").val();
    var sale_selection = $(".sale_selection");

    if (!is_sale_active || sale_selection.length == 0) {
      $("#search_by_product_name").val("");
      swal("Oops...!", "Please select a sale!", "info");
    }
    var value = $(this).val();
    if (is_sale_active && $(this).val().length > 1) {
      var barcode = $("#search_by_product_name").val();
      if (ev.keyCode == 13) {
        $.ajax({
          url: base_url + "sale/search_product_by_barcode",
          dataType: "json",
          type: "POST",
          cache: false,
          data: { barcode: barcode },
          success: function (result) {
            const item = {
              id: result.id,
              label: result.product_name,
              product_size: result.product_size,
              company_name: result.company_name,
              catagory_name: result.catagory_name,
              product_model: result.product_model,
              sale_price: result.sale_price,
              mrp_price: result.mrp_price,
              buy_price: result.buy_price,
              stock: result.stock,
              generic_name: result.generic_name,
              temp_pro_data: result.temp_pro_data,
              product_specification: result.product_specification,
            };
            showSelectedProduct(item);
          },
        });
      } else {
        $("#search_by_product_name").autocomplete({
          source: function (request, response) {
            $.ajax({
              url: base_url + "sale/search_product2",
              dataType: "json",
              type: "POST",
              cache: false,
              data: { term: request.term, flag: 1 },
              success: function (result) {
                response(
                  $.map(result, function (item) {
                    return {
                      id: item.id,
                      label: item.product_name,
                      product_size: item.product_size,
                      company_name: item.company_name,
                      catagory_name: item.catagory_name,
                      product_model: item.product_model,
                      sale_price: item.sale_price,
                      mrp_price: item.mrp_price,
                      buy_price: item.buy_price,
                      stock: item.stock,
                      generic_name: item.generic_name,
                      temp_pro_data: item.temp_pro_data,
                      product_specification: item.product_specification,
                    };
                  })
                );
              },
            });
          },
          minLength: 1,
          select: function (event, ui) {
            showSelectedProduct(ui.item);
          },
        });

        $("#search_by_product_name").autocomplete(
          "instance"
        )._renderItem = function (ul, item) {
          return $('<li style="border-bottom: 2px solid gray; hover: red;">')
            .append(
              '<div><span class="label_style text-bold">' +
                item.label +
                "</span><span> " +
                item.catagory_name +
                " " +
                item.product_size +
                '</span><br><span style="font-size: 12px !important;">' +
                item.generic_name +
                "    " +
                item.catagory_name +
                "    </span><span style='color:#00cd6e;'> (Stock: " +
                item.stock +
                ")</span> <span style='color:#00cd6e;'> (Pack: " +
                item.product_model +
                ')</span><br><span style="font-size: 12px !important;">' +
                item.company_name +
                "</span></div>"
            )
            .appendTo(ul);
        };
      }
    }
  });

  function showSelectedProduct(item) {
    var stock = item.stock;
    if (stock == 0 && allow_negative_stock == 0) {
      $("#search_by_product_name").val("");
      alert("Stock unavailable");
      $("#search_by_product_name").focus();
    } else {
      var new_sale_price = parseFloat(item.sale_price);
      var new_mrp_price = parseFloat(item.mrp_price);
      var new_buy_price = parseFloat(item.buy_price);

      $("#price").val(new_sale_price);
      $("#mrp_price").val(new_mrp_price);
      $("#sale_price").val(new_sale_price);
      $("#buy_price").val(new_buy_price);

      var sale_price_check = parseFloat(item.mrp_price);
      var stock_check = parseFloat(item.stock);
      if (sale_price_check == 0 && stock_check == 0) {
        $("#buy_price_check").prop("disabled", true);
        $("#new_mrp_price").prop("disabled", false);
        $("#new_mrp_price").focus();
      } else {
        $("#buy_price_check").prop("disabled", true);
        $("#new_mrp_price").prop("disabled", true);
        $("#product_quantity").focus();
      }
      $("#buy_price_check").val(new_buy_price);
      $("#new_mrp_price").val(new_sale_price);
      $("#pro_name").val(item.label);
      $("#temp_pro_data").val(item.temp_pro_data);
      $("#temp_pro_id").val(item.id);
      $("#search_by_product_name").val(item.label);
      $("#product_specification").val(item.product_specification);
      $("#temp_pro_qty").val(item.stock);
    }
  }

  $("#search_by_customer_name").on("keyup", function (ev) {
    var is_sale_active = $("#is_sale_active").val();
    var allow_negative_stock = $("#allow_negative_stock").val();
    var sale_selection = $(".sale_selection");

    if (!is_sale_active || sale_selection.length == 0) {
      $("#search_by_customer_name").val("");
      swal("Oops...!", "Please select a sale!", "info");
    }
    if (is_sale_active) {
      $("#search_by_customer_name").autocomplete({
        source: function (request, response) {
          $.ajax({
            url: base_url + "customer/search_customer_by_name",
            dataType: "json",
            type: "POST",
            cache: false,
            data: { term: request.term, flag: 1 },
            success: function (result) {
              response(
                $.map(result, function (item) {
                  return {
                    id: item.customer_id,
                    value: item.customer_name,
                    label: item.customer_name,
                  };
                })
              );
            },
          });
        },
        minLength: 1,
        select: function (event, ui) {
          $("#selected_customer_id").val(ui.item.id);
        },
      });
    }
  });

  $("#search_by_warran_product_model").on("keyup", function (ev) {
    var is_sale_active = $("#is_sale_active").val();
    var sale_selection = $(".sale_selection");

    if (!is_sale_active || sale_selection.length == 0) {
      $("#search_by_warran_product_model").val("");
      swal("Oops...!", "Please select a sale!", "info");
    }
    var value = $(this).val();
    var barcode = $("#search_by_product_name").val();
    if (is_sale_active) {
      $("#search_by_warran_product_model").autocomplete({
        source: function (request, response) {
          $.ajax({
            url: base_url + "sale/search_product_warranty",
            dataType: "json",
            type: "POST",
            cache: false,
            data: { barcode: barcode, flag: 1 },
            success: function (result) {
              console.log(result);
              response(
                $.map(result, function (item) {
                  return {
                    id: item.id,
                    label: item.product_name,
                    product_size: item.product_size,
                    product_model: item.product_model,
                    sale_price: item.sale_price,
                    mrp_price: item.mrp_price,
                    buy_price: item.buy_price,
                    stock: item.stock,
                    generic_name: item.generic_name,
                    temp_pro_data: item.temp_pro_data,
                    product_specification: item.product_specification,
                  };
                })
              );
            },
          });
        },
        minLength: 1,
        select: function (event, ui) {
          showSelectedProduct(ui.item);
        },
      });

      $("#search_by_warran_product_model").autocomplete(
        "instance"
      )._renderItem = function (ul, item) {
        return $('<li style="border-bottom: 2px solid gray; hover: red;">')
          .append(
            '<div><span class="label_style">' +
              item.label +
              " " +
              item.catagory_name +
              " " +
              item.product_size +
              "</span><br>" +
              item.generic_name +
              "    " +
              item.catagory_name +
              "    <span style='color:#00cd6e;'> (Stock: " +
              item.stock +
              ")</span> <span style='color:#00cd6e;'> (Pack: " +
              item.product_model +
              ")</span><br>" +
              item.company_name +
              "</div>"
          )
          .appendTo(ul);
      };
    } else {
      $(this).val("");
      alert("Plz select or create a sale");
    }
  });

  $("#product_quantity").on("keydown", function (e) {
    if (e.keyCode === 13) {
      var num_of_tr = $("#selected_products tr").length;
      var stock = $("#temp_pro_qty").val();
      var cstock = parseFloat(stock);
      var qnty = $("#product_quantity").val();
      var rstock = parseFloat(qnty);
      var str_Price = $("#price").val();
      var pro_price = parseFloat(str_Price);

      var mrp_price = $("#mrp_price").val();
      var mrp_price = parseFloat(mrp_price); // general_unit_sale_price
      var sale_price = $("#sale_price").val();
      var sale_price = parseFloat(sale_price); // unit_sale_price
      var buy_price = $("#buy_price").val();
      var buy_price = parseFloat(buy_price); // unit_buy_price

      var str_mrp_Price = $("#new_mrp_price").val();
      var pro_mrp_price = parseFloat(str_mrp_Price);
      var str_sub_total = $("#sub_total").val();
      var tmp_sub_total = parseFloat(str_sub_total);
      var str_total_vat = $("#vat").val();
      var total_vat = parseFloat(str_total_vat);
      var str_num_of_pro = $("#number_of_products").val();
      var num_of_pro = parseInt(str_num_of_pro);
      var return_adjust = $("#return_adjust").val();
      var product_specification = $("#product_specification").val();
      var pro_id = $("#temp_pro_id").val();
      var pro_name = $("#pro_name").val();
      var value_added_tax = parseFloat($("#value_added_tax").val());
      if (
        qnty != "" &&
        !isNaN(qnty) &&
        qnty > 0 &&
        $("#temp_pro_data").val() != ""
      ) {
        tmp_sub_total = tmp_sub_total;
        total_vat = total_vat;
        var old_qnty = "";
        var price = "";
        var new_qnty = "";
        var new_stock = "";
        var new_price = "";
        var selected_row = "";
        var temp_amount = "";
        var total_2 = "";
        var tmp_vat = 0;
        if (str_num_of_pro != "") {
          num_of_pro += rstock;
          $("#number_of_products").val(num_of_pro);
        } else {
          $("#number_of_products").val(rstock);
        }
        var vat = (pro_price * rstock * value_added_tax) / 100;
        if (str_total_vat != "") vat += total_vat;
        vat = vat;
        var selected_producted = $("#pro_name").val();
        var flg = false;
        $("#selected_products tr").each(function () {
          if (selected_producted == $(this).find("td:nth-child(1)").text()) {
            flg = true;
            old_qnty = $(this).find("td:nth-child(3)").text();
            price = $(this).find("td:nth-child(4)").text();
            selected_row = $(this);
            price = parseFloat(price);
            old_qnty = parseInt(old_qnty);
            new_qnty = rstock + old_qnty;
            temp_amount = rstock * pro_price;
            if (str_sub_total != "") temp_amount += tmp_sub_total;
            temp_amount = temp_amount;
            total_2 = temp_amount + vat;
            new_price = price * new_qnty;
          }
        });

        if (product_specification == 2) {
          $("#indi_pro_name").html("Serial setup for " + selected_producted);
          $("#show_product_individual_add_modal").modal("show");
          var submiturl = base_url + "sale/getIndiVidualProduct_warranty_new";
          var methods = "POST";
          var output = "";
          var input_box = "";
          $.ajax({
            url: submiturl,
            type: methods,
            dataType: "JSON",
            data: { product_id: pro_id },
            success: function (result) {
              for (var ii = 0; ii < result.length; ii++) {
                output +=
                  '<option value="' +
                  result[ii].ip_id +
                  '">' +
                  result[ii].sl_no +
                  "</option>";
              }
              for (var i = 1; i <= qnty; i++) {
                input_box +=
                  '<div class="form-group"><label for="inputEmail3" class="col-sm-3 control-label">' +
                  i +
                  '. Serial No</label><div class="col-sm-9"><select class="form-control product_type select223" id="product_type" name="product_type"><option value="">Select Serial</option>' +
                  output +
                  "</select></div></div>";
              }
              $("#pro_serial_input").html(input_box);
            },
          });

          $("#add_product_serial_form").on("submit", function (service) {
            service.preventDefault();
            var submiturl = $(this).attr("action");
            var methods = $(this).attr("method");
            var data = $(this).serialize();
            var new_temp_sale_id = $("#new_temp_sale_id").val();
            console.log(data);
            $.ajax({
              url: submiturl,
              type: methods,
              data: {
                product_type: data,
                product_id: pro_id,
                new_temp_sale_id: new_temp_sale_id,
              },
              cache: false,
              success: function (result) {
                var temp_data = $("#temp_pro_data").val();
                num_of_tr += 1;
                var tmp_amount = rstock * pro_price;
                tmp_amount = tmp_amount;
                var total = tmp_amount + vat;
                $.ajax({
                  url: base_url + "sale/addProductToSale",
                  type: "POST",
                  cache: false,
                  data: {
                    product_id: pro_id,
                    product_name: pro_name,
                    pro_mrp_price: pro_mrp_price,
                    sale_price: sale_price,
                    buy_price: buy_price,
                    product_specification: product_specification,
                    pro_quantity: rstock,
                    cstock: cstock,
                    num_of_row: num_of_tr,

                    temp_data: temp_data,
                    total: total,
                  },
                  success: function (res) {
                    $("#search_by_product_name").focus();
                    location.reload();
                  },
                });
              },
            });
          });
        } else {
          var temp_data = $("#temp_pro_data").val();
          num_of_tr += 1;
          var tmp_amount = rstock * pro_price;
          if (str_sub_total != "") tmp_amount += tmp_sub_total;
          tmp_amount = tmp_amount;
          var total = tmp_amount + vat;
          $("#sub_total").val(tmp_amount);
          $("#vat").val(vat);
          $("#number_of_products").val();

          if (return_adjust != "" && !isNaN(return_adjust)) {
            return_adjust = parseFloat(return_adjust);
            total -= return_adjust;
            var pybl = total - return_adjust;
            if (pybl > 0) $("#payable").val(pybl);
            else $("#payable").val(0);
          }

          $("#total").val(total);
          $.ajax({
            url: base_url + "sale/addProductToSale",
            type: "POST",
            cache: false,
            data: {
              product_id: pro_id,
              product_name: pro_name,
              pro_mrp_price: mrp_price,
              sale_price: sale_price,
              buy_price: buy_price,
              product_specification: product_specification,
              pro_quantity: rstock,
              cstock: cstock,
              num_of_row: num_of_tr,

              temp_data: temp_data,
              total: total,
            },
            success: function (res) {
              $("#selected_products").last().append(res);
              $("#search_by_product_name").val("");
              $("#search_by_product_name").focus();
              var in_words = convert_number_to_words(total);
              $("#inword").val(in_words + " (TK)");
              $("#search_by_product_name").val("");
              $("#product_quantity").val("");
              $("#temp_pro_data").val("");
              $("#search_by_product_name").focus();
              location.reload();
            },
          });
        }
      }
    }
  });
});

// create new customer
$(document).ready(function () {
  $("#close_customer_modal").click(function () {
    $("#customer").trigger("reset");
    $("#customer").find(".has-error").removeClass("has-error");
    $("#customer").find(".text-danger").remove();
    $("#exampleModal").modal("hide");
  });
  $("#received").on("keyup", function (service) {
    var length = $(this).val().length;
    if (length >= 1) {
      $("#credit_sale").prop("disabled", true);
    } else {
      $("#credit_sale").prop("disabled", false);
    }
  });

  $("#customer").submit(function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    var url = $(this).attr("action");
    $.ajax({
      url: url,
      method: "POST",
      data: data,
      dataType: "json",
      success: function (res) {
        if (res.check == true) {
          $("#customer").find(".has-error").removeClass("has-error");
          $("#customer").find(".text-danger").remove();
          if (res.success == true) {
            $.each(res.data, function () {
              $("#selected_customer_id").val(this.customer_id);
              $("#search_by_customer_name").val(this.customer_name);
            });
            $("#customer").trigger("reset");
            $("#exampleModal").modal("hide");
          }
        } else {
          $.each(res.errors, function (key, value) {
            var el = $("." + key);
            el.removeClass("has-error")
              .addClass(value.length > 0 ? "has-error" : "has-success")
              .siblings("p.text-danger")
              .remove();
            el.after(value);
          });
        }
      },
    });
  });
});

$(document).ready(function () {
  var is_sale_active = $("#is_sale_active").val();
  if (is_sale_active == "") {
    $.ajax({
      url: base_url + "sale/select_active_sale",
      type: "POST",
      success: function (result) {
        $("#sale_new" + result).trigger("click");
      },
    });
  } else {
    console.log("will create a new temp sale");
  }
});
/* Start: Script for sale. */
$(function () {
  $("#total").hover(function () {
    var sub_total = $("#sub_total").val();
    sub_total = isNaN(parseFloat(sub_total)) ? 0 : sub_total;

    var disc_amount = $("#disc_amount").val();
    disc_amount = isNaN(parseFloat(disc_amount)) ? 0 : disc_amount;
    var hid_vat = $("#hid_vat").val();
    hid_vat = hid_vat ? 0 : hid_vat;
    var hid_total_buy_price = $("#hid_total_buy_price").val();
    hid_total_buy_price = isNaN(parseFloat(hid_total_buy_price))
      ? 0
      : hid_total_buy_price;
    var profit =
      parseFloat(sub_total) -
      parseFloat(hid_total_buy_price) -
      parseFloat(disc_amount) +
      parseFloat(hid_vat);
    profit = isNaN(parseFloat(profit)) ? 0 : profit;
    $("#total").attr("title", parseFloat(profit).toFixed(2));
  });
  var hid_qty = $("#hid_qty").val();
  var hid_sub_to = $("#hid_sub_to").val();
  var hid_vat = $("#hid_vat").val();

  hid_qty = parseFloat(hid_qty).toFixed(2);
  hid_sub_to = parseFloat(hid_sub_to).toFixed(2);
  hid_vat = parseFloat(hid_vat).toFixed(2);

  if (hid_qty != "" && hid_sub_to != "" && hid_vat != "") {
    $("#number_of_products").val(hid_qty);
    $("#sub_total").val(hid_sub_to);
    $("#vat").val(hid_vat);
  }

  var re_ajd = $("#hid_return_adjust").val();
  re_ajd = parseFloat(re_ajd).toFixed(2);

  var tmp = parseFloat(hid_sub_to) + parseFloat(hid_vat);
  tmp = parseFloat(tmp).toFixed(2);
  if (re_ajd > 0) {
    tmp -= re_ajd;
    var pybl = tmp - re_ajd;
    pybl = parseFloat(pybl).toFixed(2);

    $("#return_adjust").val(re_ajd);
    if (pybl > 0) $("#payable").val(pybl);
    else $("#payable").val(0);
  } else $("#payable").val(tmp);

  if (!isNaN(tmp)) {
    $("#total").val(tmp);
    var str_received = $("#received").val();
    var dif = str_received + re_ajd - hid_sub_to;
    dif = dif >= 0 ? dif : 0;
    $("#change").val(parseFloat(dif).toFixed(2));
    var txt = convert_number_to_words(tmp) + " (TK)";
    $("#inword").val(txt);
  }
});

$(".delete_product").click(function () {
  var edit_id = $(this).attr("id");
  var kval = edit_id.substring(6, 50);
  var product_id = $("#pro_duct_idd" + kval).val();
  var product_qnty = $("#quantti_id" + kval).val();
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
      url: base_url + "sale/removeProduct",
      type: "POST",
      cache: false,
      data: { product_id: product_id, Quantity: product_qnty },
      success: function (result) {
        swal("Deleted!", "Data Delete Successfully..!)", "success");
        location.reload();
      },
    });
  });
});

$("#new_mrp_price").on("keydown", function (e) {
  if (e.keyCode === 13) {
    $("#product_quantity").focus();
  }
});

$("#product_quantity").on("keyup", function (e) {
  var stock = $("#temp_pro_qty").val();
  var cstock = parseFloat(stock);
  var qnty = $("#product_quantity").val();
  var rstock = parseFloat(qnty);
  var allow_negative_stock = $("#allow_negative_stock").val();
  $("#product_quantity").css({ color: "black" });

  if ($.type(rstock) != "number") {
    alert("Invalid Input");
    $("#product_quantity").val("");
  } else if (
    rstock > cstock &&
    e.which != 8 &&
    e.which != 13 &&
    allow_negative_stock == 0
  ) {
    $("#product_quantity").css({ color: "red" });
    alert("Stock unavailable " + cstock);
    $("#search").val("");
    $("#product_quantity").val("");
    $("#search").focus();
    $("#product_quantity").css({ color: "black" });
  }
});

// for cancel a set sate
$("#cancel").on("click", function () {
  var is_sale_active = $("#is_sale_active").val();
  if (is_sale_active) {
    swal({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#db8b0b",
      cancelButtonColor: "#008d4c",
      confirmButtonText: "Yes",
      cancelButtonText: "No",
    }).then(function () {
      $("#sub_total").val("");
      $("#vat").val("");
      $("#disc_in_p").val("");
      $("#disc_in_f").val("");
      $("#disc_amount").val("");
      $("#total").val("");
      $("#received").val("");
      $("#change").val("");
      $("#number_of_products").val("");
      $("#select_customer").val("");
      $("#customer_name").val("");
      $("#customer_phone").val("");
      $("#selected_products").empty();
      $("#inword").val("");
      $("#return_adjust").val("");
      $("#payable").val("");
      $.ajax({
        url: base_url + "sale/cancelSale",
        type: "POST",
        cache: false,
        data: {},
        success: function (result) {
          swal("Deleted!", "Your file has been deleted.", "success");
          location.reload();
          $("#search_by_product_name").focus();
        },
      });
    });
  } else {
    swal("Oops...!", "Please select a sale!", "info");
  }
});
/* delete product from sale listingg */
$("#selected_product_list_tbl").on("click", "#delete", function () {
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
    var product_id = parseInt($("#pro_duct_id").val());
    var product_qnty = parseFloat($("#sale_stock_id").val());
    $.ajax({
      url: base_url + "sale/removeProduct",
      type: "POST",
      cache: false,
      data: { product_id: product_id, Quantity: product_qnty },
      success: function (result) {
        swal("Deleted!", ":)", "success");
        location.reload();
      },
    });
  });
});

/* edit current from sale listingg */
$(".edit_quantty").click(function () {
  var edit_id = $(this).attr("id");
  var kval = edit_id.substring(4, 10000000000);
  var quantity = $("#quantti_id" + kval).val();
  var stock = $("#stock_id" + kval).val();
  var sale = $("#sale_id" + kval).val();
  var buy = $("#buy_id" + kval).val();
  var temp_details_id = $("#temp_details_modal" + kval).val();
  var specification_id = $("#specification_id" + kval).val();
  var temp_sale_id = $("#new_temp_sale_id").val();
  var product_id = $("#pro_duct_idd" + kval).val();
  $("#show_quantty_modal").modal("show");
  if (specification_id == 2) {
    $("#quantityy").keyup(function () {
      var new_quantity = $(this).val();

      quantity = parseInt(new_quantity);

      $(".pro_serial_input_for_edit").show();
      $(".quantityy").val(quantity);
      $(".stockk").val(stock);
      $(".salee").val(sale);
      $(".buyy").val(buy);
      $(".temp_details_id").val(temp_details_id);
      $(".specification_details_id").val(specification_id);
      $(".temp_sale_id_details_id").val(temp_sale_id);
      $(".pro_details_id").val(product_id);

      var submiturl = base_url + "sale/getIndiVidualProduct_warranty";
      var methods = "POST";
      var output = "";
      var output1 = new Array();
      var input_box = "";
      var selected = "";
      var pro_name_serial = "";
      var k = 1;
      $.ajax({
        url: submiturl,
        type: methods,
        dataType: "JSON",
        data: { product_id: product_id },
        success: function (result) {
          for (var i = 0; i < quantity; i++) {
            output = "";
            for (var ii = 0; ii < result["all_data"].length; ii++) {
              if (i < result["selected_data"].length) {
                if (
                  result["selected_data"][i].ip_id ==
                  result["all_data"][ii].ip_id
                ) {
                  selected = "selected";
                } else {
                  selected = "";
                }
              } else {
                selected = "";
              }
              output +=
                '<option value="' +
                result["all_data"][ii].ip_id +
                '" ' +
                selected +
                ">" +
                result["all_data"][ii].sl_no +
                "</option>";
            }
            input_box +=
              '<div class="form-group"><label for="inputEmail3" class="col-sm-3 control-label">' +
              k +
              '. Serial No</label><div class="col-sm-9"><select class="form-control product_type select223" id="product_type" name="product_type[]" required="on"><option value="">Select Serial</option>' +
              output +
              "</select></div></div>";
            k++;
          }
          $(".pro_serial_input_for_edit_new").html(input_box);
        },
      });
    });

    $(".pro_serial_input_for_edit").show();
    $(".quantityy").val(quantity);
    $(".stockk").val(stock);
    $(".salee").val(sale);
    $(".buyy").val(buy);
    $(".temp_details_id").val(temp_details_id);
    $(".specification_details_id").val(specification_id);
    $(".temp_sale_id_details_id").val(temp_sale_id);
    $(".pro_details_id").val(product_id);

    var submiturl = base_url + "sale/getIndiVidualProduct_warranty";
    var methods = "POST";
    var output = "";
    var output1 = new Array();
    var input_box = "";
    var selected = "";
    var pro_name_serial = "";
    var k = 1;
    $.ajax({
      url: submiturl,
      type: methods,
      dataType: "JSON",
      data: { product_id: product_id },
      success: function (result) {
        for (var i = 0; i < quantity; i++) {
          output = "";
          for (var ii = 0; ii < result["all_data"].length; ii++) {
            if (i < result["selected_data"].length) {
              if (
                result["selected_data"][i].ip_id == result["all_data"][ii].ip_id
              ) {
                selected = "selected";
              } else {
                selected = "";
              }
            } else {
              selected = "";
            }
            output +=
              '<option value="' +
              result["all_data"][ii].ip_id +
              '" ' +
              selected +
              ">" +
              result["all_data"][ii].sl_no +
              "</option>";
          }
          input_box +=
            '<div class="form-group"><label for="inputEmail3" class="col-sm-3 control-label">' +
            k +
            '. Serial No</label><div class="col-sm-9"><select class="form-control product_type select223" id="product_type" name="product_type[]" required="on"><option value="">Select Serial</option>' +
            output +
            "</select></div></div>";
          k++;
        }
        $(".pro_serial_input_for_edit_new").html(input_box);
      },
    });
  } else {
    $(".pre_pro_name_serialclass").hide();
    $(".pro_serial_input_for_edit").hide();
    $(".quantityy").val(quantity);
    $(".stockk").val(stock);
    $(".salee").val(sale);
    $(".buyy").val(buy);
    $(".temp_details_id").val(temp_details_id);
    $(".specification_details_id").val(specification_id);
    $(".temp_sale_id_details_id").val(temp_sale_id);
    $(".pro_details_id").val(kval);
  }
});

$("#change_quanttyy_form").on("submit", function (uxchomp) {
  uxchomp.preventDefault();
  var submiturl = $(this).attr("action");
  var methods = $(this).attr("method");

  $.ajax({
    url: submiturl,
    type: methods,
    data: $(this).serialize(),
    success: function (result) {
      $("#show_quantty_modal").modal("hide");
      if (result == "success") {
        swal("Saved!", "Data Successfully Edited.)", "success");
        location.reload();
      } else {
        swal("Opss!", "Data Successfully Not Edited.)", "info");
        location.reload();
      }
    },
    error: function (jXHR, textStatus, errorThrown) {
      html("");
    },
  });
});
/* End    : Edit */
$("#select_customer").on("change", function (evv) {
  evv.preventDefault();
  var customer_id = $(this).val();
  $("#selected_customer_id").val(customer_id);
});
/* Start    : Quick Sale */
$("#received").on("keyup", function (efs) {
  efs.defaultPrevented;
  if (efs.keyCode == 13) {
    var received_amount = parseFloat($("#received").val());
    var total_amount = parseFloat($("#total").val());
    var customer = parseInt($("#selected_customer_id").val());
    var payable = parseFloat($("#payable").val());
    if (received_amount < total_amount && isNaN(customer)) {
      $("#received_alert").show();
      $("#received_alert").html("Received Amount Less Then Total Amount");
      alert("Select Customer.");
    } else if (received_amount < total_amount && !isNaN(customer)) {
      quick(efs);
    } else if (received_amount >= total_amount) {
      quick(efs);
    }
  } else {
    $("#received_alert").hide();
    $("#received").focus();
  }
});
// quick_sale or cash sale start
$("#quick_sale").on("click", function (e) {
  var grand_total = $("#total").val();
  var change = $("#change").val();
  if (grand_total > 0) {
    if (change !== "" && parseFloat(change) >= 0) {
      quick(e);
    } else {
      swal(
        "Oops...!",
        "Received amount must be greater then or equal to total price!",
        "info"
      );
    }
  } else {
    swal("Oops...!", "Grand total must be greater then zero!", "info");
  }
});

function quick(e) {
  //e.defaultPrevented;
  var is_sale_active = $("#is_sale_active").val();

  if (!is_sale_active) {
    swal("Oops...!", "Please select a sale!", "info");
  } else {
    swal({
      title: "Are You Sure About Sale?",
      text: "You won't be able to revert this!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#db8b0b",
      cancelButtonColor: "#008d4c",
      confirmButtonText: "Yes",
      cancelButtonText: "No",
    }).then(function () {
      var sub_total = parseFloat($("#sub_total").val());
      var vat = parseFloat($("#vat").val());
      var total = parseFloat($("#total").val());
      console.log(total);
      var received = parseFloat($("#received").val());
      var customer_id = $("#selected_customer_id").val();
      var disc_in_p = parseFloat($("#disc_in_p").val());
      var disc_in_f = parseFloat($("#disc_in_f").val());
      var disc_amount = parseFloat($("#disc_amount").val());
      var delivery_charge = parseFloat($("#delivery_charge").val());
      var customer_name = $("#customer_name").val();
      var customer_phn = $("#customer_phone").val();
      var return_adjust = parseFloat($("#return_adjust").val());
      var change = parseFloat($("#change").val());
      var payable = parseFloat($("#payable").val());
      var return_id = $("#hid_return_id").val();
      var discount_limit = $("#discount_limit").val();

      var is_valid = true;
      var message = "";
      console.log(customer_id);
      if (disc_amount > total && discount_limit == 0) {
        message = "Discount Amount is Greater Than Total Amount!";
        is_valid = false;
      }
      if (sub_total == "") {
        is_valid = false;
        message = "Sub-total should not be empty";
      }
      if (received < total) {
        is_valid = false;
        message =
          "Received amount must be greater then or equal to total price";
      }
      if (total === "") {
        is_valid = false;
        message = "Total price should not be empty";
      }

      if (is_valid) {
        $.ajax({
          url: base_url + "sale/doSale",
          type: "POST",
          cache: false,
          async: false,
          data: {
            sub_total: sub_total,
            total_: total,
            customer_id: customer_id,
            disc_in_p: disc_in_p,
            disc_in_f: disc_in_f,
            disc_amount: disc_amount,
            received: received,
            delivery_charge: delivery_charge,
            change: change,
            customer_name: customer_name,
            customer_phn: customer_phn,
            return_adjust: return_adjust,
            payable: payable,
            return_id: return_id,
            flg: 1, /// for quick sale it is 1.
          },
          success: function (result) {
            //alert(result);
            $("#sub_total").val("");
            $("#vat").val("");
            $("#disc_in_p").val("");
            $("#disc_in_f").val("");
            $("#disc_amount").val("");
            $("#total").val("");
            $("#received").val("");
            $("#delivery_charge").val("");
            $("#change").val("");
            $("#number_of_products").val("");
            $("#select_customer").val("");
            $("#customer_name").val("");
            $("#customer_phone").val("");
            $("#inword").val("");
            $("#return_id").val("");
            $("#selected_products").empty();
            $("#sale_return_list").empty();

            location.reload();
            $("#search_by_product_name").focus();
            window.open(base_url + "invoice/index/" + result, "_blank");
          },
        });
      } else {
        swal("Oops...!", message, "warning");
      }
    });
  }
}
// credit_sale sale start
$("#credit_sale").on("click", function (e) {
  if (e.originalEvent.defaultPrevented) return;

  var is_sale_active = $("#is_sale_active").val();

  if (!is_sale_active) {
    swal("Oops...!", "Please select a sale!", "info");
  } else {
    var sub_total = $("#sub_total").val();
    var vat = $("#vat").val();
    var total = parseFloat($("#total").val());
    var received = $("#received").val();
    var customer_id = $("#selected_customer_id").val();
    var disc_in_p = $("#disc_in_p").val();
    var disc_in_f = $("#disc_in_f").val();
    var disc_amount = parseFloat($("#disc_amount").val());
    var delivery_charge = parseFloat($("#delivery_charge").val());
    var customer_name = $("#customer_name").val();
    var customer_phn = $("#customer_phone").val();
    var return_adjust = $("#return_adjust").val();
    var change = $("#change").val();
    var payable = $("#payable").val();
    var return_id = $("#hid_return_id").val();

    var is_valid = true;
    var message = "";
    console.log(customer_id);
    if (disc_amount > total) {
      message = "Discount Amount is Greater Than Total Amount!";
      is_valid = false;
    }
    if (sub_total == "") {
      is_valid = false;
      message = "Sub-total should not be empty";
    }
    if (customer_id == "") {
      is_valid = false;
      message = "Please select a customer";
    }
    if (total == "") {
      is_valid = false;
      message = "Total price should not be empty";
    }

    if (is_valid) {
      swal({
        title: "Are You Sure About Credit Sale?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#db8b0b",
        cancelButtonColor: "#008d4c",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
      }).then(function () {
        $.ajax({
          url: base_url + "sale/doSale_credit",
          type: "POST",
          cache: false,
          async: false,
          data: {
            sub_total: sub_total,
            total_: total,
            customer_id: customer_id,
            disc_in_p: disc_in_p,
            disc_in_f: disc_in_f,
            disc_amount: disc_amount,
            received: received,
            delivery_charge: delivery_charge,
            change: change,
            customer_name: customer_name,
            customer_phn: customer_phn,
            return_adjust: return_adjust,
            payable: payable,
            return_id: return_id,
            flg: 1, /// for quick sale it is 1.
          },
          success: function (result) {
            $("#sub_total").val("");
            $("#vat").val("");
            $("#disc_in_p").val("");
            $("#disc_in_f").val("");
            $("#disc_amount").val("");
            $("#total").val("");
            $("#received").val("");
            $("#delivery_charge").val("");
            $("#change").val("");
            $("#number_of_products").val("");
            $("#select_customer").val("");
            $("#customer_name").val("");
            $("#customer_phone").val("");
            $("#inword").val("");
            $("#return_id").val("");
            $("#selected_products").empty();
            $("#sale_return_list").empty();

            location.reload();
            $("#search_by_product_name").focus();
            window.open(base_url + "invoice/index/" + result, "_blank");
          },
        });
      });
    } else {
      swal("Oops...!", message, "warning");
    }
    // var customer = $("#selected_customer_id").val();
    // var received = $("#received").val();
    // var total = $("#total").val();
    // if (customer !== '') {
    // 	if(received === '' || parseFloat(received) < parseFloat(total)) {

    // 	} else {
    // 		swal(
    // 			'Oops...!',
    // 			'received price must be zero or less than total price!',
    // 			'info'
    // 		  );
    // 	}

    // } else {
    // 	swal(
    // 		'Oops...!',
    // 		'Please select a customer!',
    // 		'info'
    // 	  );
    // }
  }
});
// master card sale start
$("#master_id").on("click", function (e) {
  if (e.originalEvent.defaultPrevented) return;

  var is_sale_active = $("#is_sale_active").val();

  if (!is_sale_active) {
    swal("Oops...!", "Please select a sale!", "info");
  } else {
    swal({
      title: "Are You Sure About Mastercard Sale?",
      text: "You won't be able to revert this!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#db8b0b",
      cancelButtonColor: "#008d4c",
      confirmButtonText: "Yes",
      cancelButtonText: "No",
    }).then(function () {
      var bank_id = $("#bank_id").val();
      var card_id = $("#master_id").val();
      var sub_total = $("#sub_total").val();
      var vat = $("#vat").val();
      var total = $("#total").val();
      var received = $("#received").val();
      var delivery_charge = $("#delivery_charge").val();
      var customer_id = $("#selected_customer_id").val();
      var disc_in_p = $("#disc_in_p").val();
      var disc_in_f = $("#disc_in_f").val();
      var disc_amount = $("#disc_amount").val();
      var customer_name = $("#customer_name").val();
      var customer_phn = $("#customer_phone").val();
      var return_adjust = $("#return_adjust").val();
      var change = $("#change").val();
      var payable = $("#payable").val();
      var return_id = $("#hid_return_id").val();

      if (return_adjust != "") {
        if (received != payable) {
          alert("Your Paid Amount is smaller then Payble.");
        } else if (received == payable && isNaN(customer_id)) {
          alert("Please Select Customer");
        } else if (isNaN(received) && isNaN(customer_id)) {
          alert("Please Select Paid Amount & Customer");
        } else {
          $.ajax({
            url: base_url + "sale/doSale_card",
            type: "POST",
            cache: false,
            async: false,
            data: {
              sub_total: sub_total,
              total_: total,
              customer_id: customer_id,
              disc_in_p: disc_in_p,
              disc_in_f: disc_in_f,
              disc_amount: disc_amount,
              received: received,
              delivery_charge: delivery_charge,
              change: change,
              customer_name: customer_name,
              customer_phn: customer_phn,
              return_adjust: return_adjust,
              card_id: card_id,
              bank_id: bank_id,
              payable: payable,
              return_id: return_id,
              flg: 1, /// for quick sale it is 1.
            },
            success: function (result) {
              //alert(result);
              $("#sub_total").val("");
              $("#vat").val("");
              $("#disc_in_p").val("");
              $("#disc_in_f").val("");
              $("#disc_amount").val("");
              $("#total").val("");
              $("#received").val("");
              $("#delivery_charge").val("");
              $("#change").val("");
              $("#number_of_products").val("");
              $("#select_customer").val("");
              $("#customer_name").val("");
              $("#customer_phone").val("");
              $("#inword").val("");
              $("#return_id").val("");
              $("#selected_products").empty();
              $("#sale_return_list").empty();
              var card_id2 = $("#master_id").val();
              location.reload();
              $("#search_by_product_name").focus();
              window.open(
                base_url + "invoice/index/" + result + "/" + card_id2,
                "_blank"
              );
            },
          });
        }
      } else if (received != "" && sub_total != "" && total != "") {
        $.ajax({
          url: base_url + "sale/doSale_card",
          type: "POST",
          cache: false,
          async: false,
          data: {
            sub_total: sub_total,
            total_: total,
            customer_id: customer_id,
            disc_in_p: disc_in_p,
            disc_in_f: disc_in_f,
            disc_amount: disc_amount,
            received: received,
            delivery_charge: delivery_charge,
            change: change,
            customer_name: customer_name,
            customer_phn: customer_phn,
            return_adjust: return_adjust,
            card_id: card_id,
            bank_id: bank_id,
            payable: payable,
            return_id: return_id,
            flg: 1, /// for quick sale it is 1.
          },
          success: function (result) {
            $("#sub_total").val("");
            $("#vat").val("");
            $("#disc_in_p").val("");
            $("#disc_in_f").val("");
            $("#disc_amount").val("");
            $("#total").val("");
            $("#received").val("");
            $("#delivery_charge").val("");
            $("#change").val("");
            $("#number_of_products").val("");
            $("#select_customer").val("");
            $("#customer_name").val("");
            $("#customer_phone").val("");
            $("#inword").val("");
            $("#return_id").val("");
            $("#selected_products").empty();
            $("#sale_return_list").empty();
            var card_id2 = $("#master_id").val();
            location.reload();
            $("#search_by_product_name").focus();
            window.open(
              base_url + "invoice/index/" + result + "/" + card_id2,
              "_blank"
            );
          },
        });
      } else {
        swal("Oops...!", "Data Missing!", "warning");
      }
    });
  }
});
// visa card sale start
$("#visa_id").on("click", function (e) {
  if (e.originalEvent.defaultPrevented) return;

  var is_sale_active = $("#is_sale_active").val();

  if (!is_sale_active) {
    swal("Oops...!", "Please select a sale!", "info");
  } else {
    swal({
      title: "Are You Sure About Visa Card Sale?",
      text: "You won't be able to revert this!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#db8b0b",
      cancelButtonColor: "#008d4c",
      confirmButtonText: "Yes",
      cancelButtonText: "No",
    }).then(function () {
      var bank_id = $("#bank_id").val();
      var card_id = $("#master_id").val();
      var sub_total = $("#sub_total").val();
      var vat = $("#vat").val();
      var total = $("#total").val();
      var received = $("#received").val();
      var delivery_charge = $("#delivery_charge").val();
      var customer_id = $("#selected_customer_id").val();
      var disc_in_p = $("#disc_in_p").val();
      var disc_in_f = $("#disc_in_f").val();
      var disc_amount = $("#disc_amount").val();
      var customer_name = $("#customer_name").val();
      var customer_phn = $("#customer_phone").val();
      var return_adjust = $("#return_adjust").val();
      var change = $("#change").val();
      var payable = $("#payable").val();
      var return_id = $("#hid_return_id").val();

      if (return_adjust != "") {
        if (received != payable) {
          alert("Your Paid Amount is smaller then Payble.");
        } else if (received == payable && isNaN(customer_id)) {
          alert("Please Select Customer");
        } else if (isNaN(received) && isNaN(customer_id)) {
          alert("Please Select Paid Amount & Customer");
        } else {
          $.ajax({
            url: base_url + "sale/doSale_card",
            type: "POST",
            cache: false,
            async: false,
            data: {
              sub_total: sub_total,
              total_: total,
              customer_id: customer_id,
              disc_in_p: disc_in_p,
              disc_in_f: disc_in_f,
              disc_amount: disc_amount,
              received: received,
              delivery_charge: delivery_charge,
              change: change,
              customer_name: customer_name,
              customer_phn: customer_phn,
              return_adjust: return_adjust,
              card_id: card_id,
              bank_id: bank_id,
              payable: payable,
              return_id: return_id,
              flg: 1, /// for quick sale it is 1.
            },
            success: function (result) {
              alert(result);
              $("#sub_total").val("");
              $("#vat").val("");
              $("#disc_in_p").val("");
              $("#disc_in_f").val("");
              $("#disc_amount").val("");
              $("#total").val("");
              $("#received").val("");
              $("#delivery_charge").val("");
              $("#change").val("");
              $("#number_of_products").val("");
              $("#select_customer").val("");
              $("#customer_name").val("");
              $("#customer_phone").val("");
              $("#inword").val("");
              $("#return_id").val("");
              $("#selected_products").empty();
              $("#sale_return_list").empty();
              var card_id2 = $("#master_id").val();
              location.reload();
              $("#search_by_product_name").focus();
              window.open(
                base_url + "invoice/index/" + result + "/" + card_id2,
                "_blank"
              );
            },
          });
        }
      } else if (received != "" && sub_total != "" && total != "") {
        $.ajax({
          url: base_url + "sale/doSale_card",
          type: "POST",
          cache: false,
          async: false,
          data: {
            sub_total: sub_total,
            total_: total,
            customer_id: customer_id,
            disc_in_p: disc_in_p,
            disc_in_f: disc_in_f,
            disc_amount: disc_amount,
            received: received,
            delivery_charge: delivery_charge,
            change: change,
            customer_name: customer_name,
            customer_phn: customer_phn,
            return_adjust: return_adjust,
            card_id: card_id,
            bank_id: bank_id,
            payable: payable,
            return_id: return_id,
            flg: 1, /// for quick sale it is 1.
          },
          success: function (result) {
            $("#sub_total").val("");
            $("#vat").val("");
            $("#disc_in_p").val("");
            $("#disc_in_f").val("");
            $("#disc_amount").val("");
            $("#total").val("");
            $("#received").val("");
            $("#delivery_charge").val("");
            $("#change").val("");
            $("#number_of_products").val("");
            $("#select_customer").val("");
            $("#customer_name").val("");
            $("#customer_phone").val("");
            $("#inword").val("");
            $("#return_id").val("");
            $("#selected_products").empty();
            $("#sale_return_list").empty();
            var card_id2 = $("#master_id").val();
            location.reload();
            $("#search_by_product_name").focus();
            window.open(
              base_url + "invoice/index/" + result + "/" + card_id2,
              "_blank"
            );
          },
        });
      } else {
        swal("Oops...!", "Data Missing!", "warning");
      }
    });
  }
});
// american  card sale start
$("#american_express_id").on("click", function (e) {
  if (e.originalEvent.defaultPrevented) return;

  var is_sale_active = $("#is_sale_active").val();

  if (!is_sale_active) {
    swal("Oops...!", "Please select a sale!", "info");
  } else {
    swal({
      title: "Are You Sure About American Express CardSale?",
      text: "You won't be able to revert this!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#db8b0b",
      cancelButtonColor: "#008d4c",
      confirmButtonText: "Yes",
      cancelButtonText: "No",
    }).then(function () {
      var bank_id = $("#bank_id").val();
      var card_id = $("#master_id").val();
      var sub_total = $("#sub_total").val();
      var vat = $("#vat").val();
      var total = $("#total").val();
      var received = $("#received").val();
      var delivery_charge = $("#delivery_charge").val();
      var customer_id = $("#selected_customer_id").val();
      var disc_in_p = $("#disc_in_p").val();
      var disc_in_f = $("#disc_in_f").val();
      var disc_amount = $("#disc_amount").val();
      var customer_name = $("#customer_name").val();
      var customer_phn = $("#customer_phone").val();
      var return_adjust = $("#return_adjust").val();
      var change = $("#change").val();
      var payable = $("#payable").val();
      var return_id = $("#hid_return_id").val();

      if (return_adjust != "") {
        if (received != payable) {
          alert("Your Paid Amount is smaller then Payble.");
        } else if (received == payable && isNaN(customer_id)) {
          alert("Please Select Customer");
        } else if (isNaN(received) && isNaN(customer_id)) {
          alert("Please Select Paid Amount & Customer");
        } else {
          $.ajax({
            url: base_url + "sale/doSale_card",
            type: "POST",
            cache: false,
            async: false,
            data: {
              sub_total: sub_total,
              total_: total,
              customer_id: customer_id,
              disc_in_p: disc_in_p,
              disc_in_f: disc_in_f,
              disc_amount: disc_amount,
              received: received,
              delivery_charge: delivery_charge,
              change: change,
              customer_name: customer_name,
              customer_phn: customer_phn,
              return_adjust: return_adjust,
              card_id: card_id,
              bank_id: bank_id,
              payable: payable,
              return_id: return_id,
              flg: 1, /// for quick sale it is 1.
            },
            success: function (result) {
              alert(result);
              $("#sub_total").val("");
              $("#vat").val("");
              $("#disc_in_p").val("");
              $("#disc_in_f").val("");
              $("#disc_amount").val("");
              $("#total").val("");
              $("#received").val("");
              $("#delivery_charge").val("");
              $("#change").val("");
              $("#number_of_products").val("");
              $("#select_customer").val("");
              $("#customer_name").val("");
              $("#customer_phone").val("");
              $("#inword").val("");
              $("#return_id").val("");
              $("#selected_products").empty();
              $("#sale_return_list").empty();
              var card_id2 = $("#master_id").val();
              location.reload();
              $("#search_by_product_name").focus();
              window.open(
                base_url + "invoice/index/" + result + "/" + card_id2,
                "_blank"
              );
            },
          });
        }
      } else if (received != "" && sub_total != "" && total != "") {
        $.ajax({
          url: base_url + "sale/doSale_card",
          type: "POST",
          cache: false,
          async: false,
          data: {
            sub_total: sub_total,
            total_: total,
            customer_id: customer_id,
            disc_in_p: disc_in_p,
            disc_in_f: disc_in_f,
            disc_amount: disc_amount,
            received: received,
            delivery_charge: delivery_charge,
            change: change,
            customer_name: customer_name,
            customer_phn: customer_phn,
            return_adjust: return_adjust,
            card_id: card_id,
            bank_id: bank_id,
            payable: payable,
            return_id: return_id,
            flg: 1, /// for quick sale it is 1.
          },
          success: function (result) {
            $("#sub_total").val("");
            $("#vat").val("");
            $("#disc_in_p").val("");
            $("#disc_in_f").val("");
            $("#disc_amount").val("");
            $("#total").val("");
            $("#received").val("");
            $("#delivery_charge").val("");
            $("#change").val("");
            $("#number_of_products").val("");
            $("#select_customer").val("");
            $("#customer_name").val("");
            $("#customer_phone").val("");
            $("#inword").val("");
            $("#return_id").val("");
            $("#selected_products").empty();
            $("#sale_return_list").empty();
            var card_id2 = $("#master_id").val();
            location.reload();
            $("#search_by_product_name").focus();
            window.open(
              base_url + "invoice/index/" + result + "/" + card_id2,
              "_blank"
            );
          },
        });
      } else {
        swal("Oops...!", "Data Missing!", "warning");
      }
    });
  }
});

$(document).on("keydown", function (e) {
  if (e.keyCode === 113) {
    ///F2
    var received = $("#received").is(":focus");
    var disc_p = $("#disc_in_p").is(":focus");
    var disc_f = $("#disc_in_f").is(":focus");
    var payment = $("#payment").is(":focus");

    if (disc_p) {
      $("#disc_in_f").focus();
    } else if (disc_f) {
      $("#payment").focus();
    } else if (payment) {
      $("#received").focus();
    } else if (received) {
      $("#disc_in_p").focus();
    } else {
      $("#disc_in_p").focus();
    }
  } else if (e.keyCode === 115) {
    var customer_name = $("#customer_name").is(":focus");
    var select_customer = $("#select_customer").is(":focus");

    if (select_customer) {
      $("#customer_name").focus();
    } else if (customer_name) {
      $("#select_customer").focus();
    } else {
      $("#select_customer").focus();
    }
  }
});

/* Start: Discount in %. */
$("#disc_in_p").on("keyup", function (e) {
  var disc_in_p = $(this).val();
  var disc_val = isNaN(parseFloat(disc_in_p)) ? 0 : parseFloat(disc_in_p);
  var received = $("#received").val();
  received = isNaN(parseFloat(received)) ? 0 : parseFloat(received);
  var return_adjust = $("#return_adjust").val();
  var tmp_re_ad = 0;
  var payable = 0;

  var str_sub_total = $("#sub_total").val();
  var sub_total = parseFloat(str_sub_total);

  var disc_val = (disc_val * sub_total) / 100;

  var str_vat = $("#vat").val();
  var vat = isNaN(parseFloat(str_vat)) ? 0 : parseFloat(str_vat);

  if (return_adjust != "") var tmp_re_ad = parseFloat(return_adjust);

  $("#disc_in_f").val("");
  $("#disc_amount").val(disc_val);

  var total = sub_total - tmp_re_ad - disc_val + vat;

  if (!isNaN(total)) {
    payable = total;
    $("#total").val(payable);
    $("#payable").val(payable);

    var txt = convert_number_to_words(total) + " (TK)";
    $("#inword").val(txt);
  }
  var change = received - total;
  $("#change").val(change >= 0 ? parseFloat(change).toFixed(2) : 0);
});

$("#disc_in_f").on("keyup", function () {
  var str_disc_f = $(this).val();
  var disc_val = isNaN(parseFloat(str_disc_f)) ? 0 : parseFloat(str_disc_f);
  var received = $("#received").val();
  received = isNaN(parseFloat(received)) ? 0 : parseFloat(received);
  var return_adjust = $("#return_adjust").val();
  var tmp_re_ad = 0;
  var payable = 0;

  var str_sub_total = $("#sub_total").val();
  var sub_total = parseFloat(str_sub_total);

  var str_vat = $("#vat").val();
  var vat = isNaN(parseFloat(str_vat)) ? 0 : parseFloat(str_vat);

  if (return_adjust != "") var tmp_re_ad = parseFloat(return_adjust);

  $("#disc_in_p").val("");
  $("#disc_amount").val(disc_val);

  var total = sub_total - tmp_re_ad - disc_val + vat;

  if (!isNaN(total)) {
    payable = total;
    $("#total").val(payable);
    $("#payable").val(payable);

    var txt = convert_number_to_words(total) + " (TK)";
    $("#inword").val(txt);
  }
  var change = received - total;
  $("#change").val(change >= 0 ? parseFloat(change).toFixed(2) : 0);
});

$("#received").on("keyup", function () {
  var received = $("#received").val();
  received = isNaN(parseFloat(received)) ? 0 : parseFloat(received);

  var total = $("#total").val();
  total = isNaN(parseFloat(total)) ? 0 : parseFloat(total);

  var change = received - total;
  var payable = total - received;

  $("#change").val(change >= 0 ? parseFloat(change).toFixed(2) : 0);
  $("#payable").val(payable >= 0 ? parseFloat(payable).toFixed(2) : 0);
});

// code js
function getSaleId(id) {
  var kval = id.substring(8, 1000);
  console.log(id);
  $.ajax({
    url: base_url + "sale/setCurrentSale",
    type: "POST",
    data: { id: kval },
    success: function (result) {
      location.reload();
      $("#selected_products").html(result);
      var QNTY = $("#hid_qty").val();
      var sub_total = $("#hid_sub_to").val();
      var VAT = $("#hid_vat").val();
    },
  });
}

function do_calculation(product_price) {
  alert(product_price);
}

$("#return_adjust").on("change", function () {
  alert("OK");
});

/* Shortcut Add Start*/
document.onkeyup = function (e) {
  var e = e || window.event; // for IE to cover IEs window object
  if (e.altKey && e.which == 81) {
    var change = $("#change").val();
    if (change !== "" && parseFloat(change) >= 0) {
      quick(e);
    } else {
      swal(
        "Oops...!",
        "Received amount must be greater then or equal to total price!",
        "info"
      );
    }
  } else if (e.altKey && e.which == 77) {
    var is_sale_active = $("#is_sale_active").val();
    var sale_selection = $(".sale_selection");
    console.log(sale_selection);

    if (!is_sale_active || !sale_selection) {
      swal("Oops...!", "Please select a sale!", "info");
    } else {
      swal({
        title:
          'Are You Sure About <img src=base_url+"assets/assets2/dist/img/credit/mastercard.png" alt="Mastercard"> Sale?',
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#db8b0b",
        cancelButtonColor: "#008d4c",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
      }).then(function () {
        var bank_id = $("#bank_id").val();
        var card_id = $("#master_id").val();
        var sub_total = $("#sub_total").val();
        var vat = $("#vat").val();
        var total = $("#total").val();
        var received = $("#received").val();
        var customer_id = $("#selected_customer_id").val();
        var disc_in_p = $("#disc_in_p").val();
        var disc_in_f = $("#disc_in_f").val();
        var disc_amount = $("#disc_amount").val();
        var customer_name = $("#customer_name").val();
        var customer_phn = $("#customer_phone").val();
        var return_adjust = $("#return_adjust").val();
        var change = $("#change").val();
        var payable = $("#payable").val();
        var return_id = $("#hid_return_id").val();

        if (return_adjust != "") {
          if (received != payable) {
            alert("Your Paid Amount is smaller then Payble.");
          } else if (received == payable && isNaN(customer_id)) {
            alert("Please Select Customer");
          } else if (isNaN(received) && isNaN(customer_id)) {
            alert("Please Select Paid Amount & Customer");
          } else {
            $.ajax({
              url: base_url + "sale/doSale_card",
              type: "POST",
              cache: false,
              async: false,
              data: {
                sub_total: sub_total,
                total_: total,
                customer_id: customer_id,
                disc_in_p: disc_in_p,
                disc_in_f: disc_in_f,
                disc_amount: disc_amount,
                received: received,
                change: change,
                customer_name: customer_name,
                customer_phn: customer_phn,
                return_adjust: return_adjust,
                card_id: card_id,
                bank_id: bank_id,
                payable: payable,
                return_id: return_id,
                flg: 1, /// for quick sale it is 1.
              },
              success: function (result) {
                alert(result);
                $("#sub_total").val("");
                $("#vat").val("");
                $("#disc_in_p").val("");
                $("#disc_in_f").val("");
                $("#disc_amount").val("");
                $("#total").val("");
                $("#received").val("");
                $("#change").val("");
                $("#number_of_products").val("");
                $("#select_customer").val("");
                $("#customer_name").val("");
                $("#customer_phone").val("");
                $("#inword").val("");
                $("#return_id").val("");
                $("#selected_products").empty();
                $("#sale_return_list").empty();
                var card_id2 = $("#master_id").val();
                location.reload();
                $("#search_by_product_name").focus();
                window.open(
                  base_url + "invoice/index2/" + result + "/" + card_id2,
                  "_blank"
                );
              },
            });
          }
        } else if (received != "" && sub_total != "" && total != "") {
          $.ajax({
            url: base_url + "sale/doSale_card",
            type: "POST",
            cache: false,
            async: false,
            data: {
              sub_total: sub_total,
              total_: total,
              customer_id: customer_id,
              disc_in_p: disc_in_p,
              disc_in_f: disc_in_f,
              disc_amount: disc_amount,
              received: received,
              change: change,
              customer_name: customer_name,
              customer_phn: customer_phn,
              return_adjust: return_adjust,
              card_id: card_id,
              bank_id: bank_id,
              payable: payable,
              return_id: return_id,
              flg: 1, /// for quick sale it is 1.
            },
            success: function (result) {
              $("#sub_total").val("");
              $("#vat").val("");
              $("#disc_in_p").val("");
              $("#disc_in_f").val("");
              $("#disc_amount").val("");
              $("#total").val("");
              $("#received").val("");
              $("#change").val("");
              $("#number_of_products").val("");
              $("#select_customer").val("");
              $("#customer_name").val("");
              $("#customer_phone").val("");
              $("#inword").val("");
              $("#return_id").val("");
              $("#selected_products").empty();
              $("#sale_return_list").empty();
              var card_id2 = $("#master_id").val();
              location.reload();
              $("#search_by_product_name").focus();
              window.open(
                base_url + "invoice/index2/" + result + "/" + card_id2,
                "_blank"
              );
            },
          });
        } else {
          swal("Oops...!", "Data Missing!", "warning");
        }
      });
    }
  } else if (e.altKey && e.which == 86) {
    var is_sale_active = $("#is_sale_active").val();

    if (!is_sale_active) {
      swal("Oops...!", "Please select a sale!", "info");
    } else {
      swal({
        title:
          'Are You Sure About <img src=base_url+"assets/assets2/dist/img/credit/visa.png" alt="Visa Card"> Sale?',
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#db8b0b",
        cancelButtonColor: "#008d4c",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
      }).then(function () {
        var bank_id = $("#bank_id").val();
        var card_id = $("#master_id").val();
        var sub_total = $("#sub_total").val();
        var vat = $("#vat").val();
        var total = $("#total").val();
        var received = $("#received").val();
        var customer_id = $("#selected_customer_id").val();
        var disc_in_p = $("#disc_in_p").val();
        var disc_in_f = $("#disc_in_f").val();
        var disc_amount = $("#disc_amount").val();
        var customer_name = $("#customer_name").val();
        var customer_phn = $("#customer_phone").val();
        var return_adjust = $("#return_adjust").val();
        var change = $("#change").val();
        var payable = $("#payable").val();
        var return_id = $("#hid_return_id").val();

        if (return_adjust != "") {
          if (received != payable) {
            alert("Your Paid Amount is smaller then Payble.");
          } else if (received == payable && isNaN(customer_id)) {
            alert("Please Select Customer");
          } else if (isNaN(received) && isNaN(customer_id)) {
            alert("Please Select Paid Amount & Customer");
          } else {
            $.ajax({
              url: base_url + "sale/doSale_card",
              type: "POST",
              cache: false,
              async: false,
              data: {
                sub_total: sub_total,
                total_: total,
                customer_id: customer_id,
                disc_in_p: disc_in_p,
                disc_in_f: disc_in_f,
                disc_amount: disc_amount,
                received: received,
                change: change,
                customer_name: customer_name,
                customer_phn: customer_phn,
                return_adjust: return_adjust,
                card_id: card_id,
                bank_id: bank_id,
                payable: payable,
                return_id: return_id,
                flg: 1, /// for quick sale it is 1.
              },
              success: function (result) {
                alert(result);
                $("#sub_total").val("");
                $("#vat").val("");
                $("#disc_in_p").val("");
                $("#disc_in_f").val("");
                $("#disc_amount").val("");
                $("#total").val("");
                $("#received").val("");
                $("#change").val("");
                $("#number_of_products").val("");
                $("#select_customer").val("");
                $("#customer_name").val("");
                $("#customer_phone").val("");
                $("#inword").val("");
                $("#return_id").val("");
                $("#selected_products").empty();
                $("#sale_return_list").empty();
                var card_id2 = $("#master_id").val();
                location.reload();
                $("#search_by_product_name").focus();
                window.open(
                  base_url + "invoice/index2/" + result + "/" + card_id2,
                  "_blank"
                );
              },
            });
          }
        } else if (received != "" && sub_total != "" && total != "") {
          $.ajax({
            url: base_url + "sale/doSale_card",
            type: "POST",
            cache: false,
            async: false,
            data: {
              sub_total: sub_total,
              total_: total,
              customer_id: customer_id,
              disc_in_p: disc_in_p,
              disc_in_f: disc_in_f,
              disc_amount: disc_amount,
              received: received,
              change: change,
              customer_name: customer_name,
              customer_phn: customer_phn,
              return_adjust: return_adjust,
              card_id: card_id,
              bank_id: bank_id,
              payable: payable,
              return_id: return_id,
              flg: 1, /// for quick sale it is 1.
            },
            success: function (result) {
              $("#sub_total").val("");
              $("#vat").val("");
              $("#disc_in_p").val("");
              $("#disc_in_f").val("");
              $("#disc_amount").val("");
              $("#total").val("");
              $("#received").val("");
              $("#change").val("");
              $("#number_of_products").val("");
              $("#select_customer").val("");
              $("#customer_name").val("");
              $("#customer_phone").val("");
              $("#inword").val("");
              $("#return_id").val("");
              $("#selected_products").empty();
              $("#sale_return_list").empty();
              var card_id2 = $("#master_id").val();
              location.reload();
              $("#search_by_product_name").focus();
              window.open(
                base_url + "invoice/index2/" + result + "/" + card_id2,
                "_blank"
              );
            },
          });
        } else {
          swal("Oops...!", "Data Missing!", "warning");
        }
      });
    }
  } else if (e.altKey && e.which == 65) {
    var is_sale_active = $("#is_sale_active").val();

    if (!is_sale_active) {
      swal("Oops...!", "Please select a sale!", "info");
    } else {
      swal({
        title:
          'Are You Sure About <img src=base_url+"assets/assets2/dist/img/credit/american-express.png" alt="American Express Card"> Sale?',
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#db8b0b",
        cancelButtonColor: "#008d4c",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
      }).then(function () {
        var bank_id = $("#bank_id").val();
        var card_id = $("#master_id").val();
        var sub_total = $("#sub_total").val();
        var vat = $("#vat").val();
        var total = $("#total").val();
        var received = $("#received").val();
        var customer_id = $("#selected_customer_id").val();
        var disc_in_p = $("#disc_in_p").val();
        var disc_in_f = $("#disc_in_f").val();
        var disc_amount = $("#disc_amount").val();
        var customer_name = $("#customer_name").val();
        var customer_phn = $("#customer_phone").val();
        var return_adjust = $("#return_adjust").val();
        var change = $("#change").val();
        var payable = $("#payable").val();
        var return_id = $("#hid_return_id").val();

        if (return_adjust != "") {
          if (received != payable) {
            alert("Your Paid Amount is smaller then Payble.");
          } else if (received == payable && isNaN(customer_id)) {
            alert("Please Select Customer");
          } else if (isNaN(received) && isNaN(customer_id)) {
            alert("Please Select Paid Amount & Customer");
          } else {
            $.ajax({
              url: base_url + "sale/doSale_card",
              type: "POST",
              cache: false,
              async: false,
              data: {
                sub_total: sub_total,
                total_: total,
                customer_id: customer_id,
                disc_in_p: disc_in_p,
                disc_in_f: disc_in_f,
                disc_amount: disc_amount,
                received: received,
                change: change,
                customer_name: customer_name,
                customer_phn: customer_phn,
                return_adjust: return_adjust,
                card_id: card_id,
                bank_id: bank_id,
                payable: payable,
                return_id: return_id,
                flg: 1, /// for quick sale it is 1.
              },
              success: function (result) {
                alert(result);
                $("#sub_total").val("");
                $("#vat").val("");
                $("#disc_in_p").val("");
                $("#disc_in_f").val("");
                $("#disc_amount").val("");
                $("#total").val("");
                $("#received").val("");
                $("#change").val("");
                $("#number_of_products").val("");
                $("#select_customer").val("");
                $("#customer_name").val("");
                $("#customer_phone").val("");
                $("#inword").val("");
                $("#return_id").val("");
                $("#selected_products").empty();
                $("#sale_return_list").empty();
                var card_id2 = $("#master_id").val();
                location.reload();
                $("#search_by_product_name").focus();
                window.open(
                  base_url + "invoice/index2/" + result + "/" + card_id2,
                  "_blank"
                );
              },
            });
          }
        } else if (received != "" && sub_total != "" && total != "") {
          $.ajax({
            url: base_url + "sale/doSale_card",
            type: "POST",
            cache: false,
            async: false,
            data: {
              sub_total: sub_total,
              total_: total,
              customer_id: customer_id,
              disc_in_p: disc_in_p,
              disc_in_f: disc_in_f,
              disc_amount: disc_amount,
              received: received,
              change: change,
              customer_name: customer_name,
              customer_phn: customer_phn,
              return_adjust: return_adjust,
              card_id: card_id,
              bank_id: bank_id,
              payable: payable,
              return_id: return_id,
              flg: 1, /// for quick sale it is 1.
            },
            success: function (result) {
              $("#sub_total").val("");
              $("#vat").val("");
              $("#disc_in_p").val("");
              $("#disc_in_f").val("");
              $("#disc_amount").val("");
              $("#total").val("");
              $("#received").val("");
              $("#change").val("");
              $("#number_of_products").val("");
              $("#select_customer").val("");
              $("#customer_name").val("");
              $("#customer_phone").val("");
              $("#inword").val("");
              $("#return_id").val("");
              $("#selected_products").empty();
              $("#sale_return_list").empty();
              var card_id2 = $("#master_id").val();
              location.reload();
              $("#search_by_product_name").focus();
              window.open(
                base_url + "invoice/index2/" + result + "/" + card_id2,
                "_blank"
              );
            },
          });
        } else {
          swal("Oops...!", "Data Missing!", "warning");
        }
      });
    }
  } else if (e.altKey && e.which == 67) {
    var is_sale_active = $("#is_sale_active").val();

    if (!is_sale_active) {
      swal("Oops...!", "Please select a sale!", "info");
    } else {
      swal({
        title: "Are You Sure About Credit Sale?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#db8b0b",
        cancelButtonColor: "#008d4c",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
      }).then(function () {
        var sub_total = $("#sub_total").val();
        var vat = $("#vat").val();
        var total = $("#total").val();
        var received = $("#received").val();
        var customer_id = $("#selected_customer_id").val();
        var disc_in_p = $("#disc_in_p").val();
        var disc_in_f = $("#disc_in_f").val();
        var disc_amount = $("#disc_amount").val();
        var customer_name = $("#customer_name").val();
        var customer_phn = $("#customer_phone").val();
        var return_adjust = $("#return_adjust").val();
        var change = $("#change").val();
        var payable = $("#payable").val();
        var return_id = $("#hid_return_id").val();
        if (disc_amount > total) {
          swal(
            "Oops...!",
            "Discount Amount is Greater Than Total Amount!",
            "warning"
          );
        } else {
          if (sub_total != "" && total != "" && customer_id != "") {
            $.ajax({
              url: base_url + "sale/doSale_credit",
              type: "POST",
              cache: false,
              async: false,
              data: {
                sub_total: sub_total,
                total_: total,
                customer_id: customer_id,
                disc_in_p: disc_in_p,
                disc_in_f: disc_in_f,
                disc_amount: disc_amount,
                received: received,
                change: change,
                customer_name: customer_name,
                customer_phn: customer_phn,
                return_adjust: return_adjust,
                payable: payable,
                return_id: return_id,
                flg: 1, /// for quick sale it is 1.
              },
              success: function (result) {
                $("#sub_total").val("");
                $("#vat").val("");
                $("#disc_in_p").val("");
                $("#disc_in_f").val("");
                $("#disc_amount").val("");
                $("#total").val("");
                $("#received").val("");
                $("#change").val("");
                $("#number_of_products").val("");
                $("#select_customer").val("");
                $("#customer_name").val("");
                $("#customer_phone").val("");
                $("#inword").val("");
                $("#return_id").val("");
                $("#selected_products").empty();
                $("#sale_return_list").empty();

                location.reload();
                $("#search_by_product_name").focus();
                window.open(base_url + "invoice/index/" + result, "_blank");
              },
            });
          } else {
            swal("Oops...!", "Data Missing!", "warning");
          }
        }
      });
    }
  } else if (e.altKey && e.which == 88) {
    var is_sale_active = $("#is_sale_active").val();

    if (is_sale_active) {
      swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#db8b0b",
        cancelButtonColor: "#008d4c",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
      }).then(function () {
        $("#sub_total").val("");
        $("#vat").val("");
        $("#disc_in_p").val("");
        $("#disc_in_f").val("");
        $("#disc_amount").val("");
        $("#total").val("");
        $("#received").val("");
        $("#change").val("");
        $("#number_of_products").val("");
        $("#select_customer").val("");
        $("#customer_name").val("");
        $("#customer_phone").val("");
        $("#selected_products").empty();
        $("#inword").val("");
        $("#return_adjust").val("");
        $("#payable").val("");
        $.ajax({
          url: base_url + "sale/cancelSale",
          type: "POST",
          cache: false,
          data: {},
          success: function (result) {
            swal("Deleted!", "Your file has been deleted.", "success");
            location.reload();
            $("#search_by_barcode").focus();
          },
        });
      });
    }
  } else if (e.altKey && e.which == 83) {
    $.ajax({
      url: base_url + "sale/addNewSale",
      type: "POST",
      cache: false,
      data: {},
      success: function (result) {
        location.reload();
      },
    });
  }
};

$(function () {
  $("#sale_return_modal").modal("show");
  $(".select2").select2();
  $(".select22").select2();
  $(".select2_bank").select2({
    placeholder: "Select Bank",
    allowClear: true,
  });
});
