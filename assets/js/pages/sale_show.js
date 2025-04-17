$(document).ready(function () {
    const baseUrl = $("#base-url").attr("content");
    $("#print-sale").click(function () {
        let saleId = $(this).data("sale-id");
        window.open(baseUrl + "/sales/invoice/" + saleId, "_blank");
    });
});
