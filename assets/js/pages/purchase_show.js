$(document).ready(function () {
    const baseUrl = $("#base-url").attr("content");

    // Print purchase
    $(document).on("click", "#print-purchase", function () {
        const purchaseId = $(this).data("purchase-id");
        window.open(
            baseUrl + "/purchases/" + purchaseId + "/invoice",
            "_blank"
        );
    });
});
