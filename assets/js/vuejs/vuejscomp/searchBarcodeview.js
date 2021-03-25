$(document).ready(function () {
  $("#product_id").select2();
  $("#printBarcode").click(function (e) {
    e.preventDefault();
    var url = $(this).data("url");
    $("#typeModal").modal("show");

    $("#typeSingle").click(function () {
      $(this).prop("checked", true);
      $("#typeA4").prop("checked", false);
    });

    $("#typeA4").click(function () {
      $(this).prop("checked", true);
      $("#typeSingle").prop("checked", false);
    });

    $("#submit_btn").click(function () {
        $("#typeModal").modal("hide");
      var data = $("input[name=type]:checked").val();
      window.open(`${url}/${data}`, "_blank");
    });
  });
});
