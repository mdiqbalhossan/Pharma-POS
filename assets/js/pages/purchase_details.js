$(document).ready(function () {
    let base_url = $('meta[name="base-url"]').attr("content");
    // Print purchase
    $("#print-purchase").on("click", function (e) {
        e.preventDefault();
        const purchaseId = $(this).data("purchase-id");
        window.open(base_url + "/purchases/invoice/" + purchaseId, "_blank");
    });

    // Download purchase
    $("#download-purchase").on("click", function (e) {
        e.preventDefault();
        const purchaseId = $(this).data("purchase-id");
        showNotification(
            "Downloading purchase invoice...",
            "info",
            "Purchase invoice downloaded successfully!"
        );
        window.location.href = base_url + "/purchases/download/" + purchaseId;
    });

    // Convert purchase order to purchase
    $("#convert-purchase").on("click", function (e) {
        e.preventDefault();
        const purchaseId = $(this).data("purchase-id");

        // Show loading indicator in modal body
        $("#convertPurchaseOrderModal .modal-body").html(
            '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Loading purchase details...</p></div>'
        );

        // Fetch purchase details
        $.ajax({
            url: base_url + "/purchases/get-details/" + purchaseId,
            type: "GET",
            success: function (response) {
                if (response.success) {
                    // Generate medicine table
                    let tableHtml = `
                        <p>Are you sure you want to convert this purchase order to a purchase? This will update inventory stock.</p>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th>Sale Price</th>
                                        <th>Ordered Qty</th>
                                        <th>Received Qty</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                    // Add rows for each medicine
                    response.data.medicines.forEach(function (medicine) {
                        tableHtml += `
                            <tr>
                                <td>${medicine.name}</td>
                                <td>$${parseFloat(medicine.sale_price).toFixed(
                                    2
                                )}</td>
                                <td>${medicine.pivot.quantity}</td>
                                <td>
                                    <input type="number" class="form-control received-qty" 
                                        name="received_qty[${medicine.id}]" 
                                        value="${medicine.pivot.quantity}" 
                                        min="0" max="${
                                            medicine.pivot.quantity
                                        }" readonly>
                                </td>
                            </tr>`;
                    });

                    tableHtml += `
                                </tbody>
                            </table>
                        </div>`;

                    // Update modal body with the generated table
                    $("#convertPurchaseOrderModal .modal-body").html(tableHtml);

                    // Add data attribute to convert button
                    $("#convertPurchaseOrderBtn").data(
                        "purchase-id",
                        purchaseId
                    );
                } else {
                    $("#convertPurchaseOrderModal .modal-body").html(
                        '<div class="alert alert-danger">Error loading purchase details.</div>'
                    );
                }
            },
            error: function (error) {
                console.log(error);
                $("#convertPurchaseOrderModal .modal-body").html(
                    '<div class="alert alert-danger">Error loading purchase details.</div>'
                );
            },
        });
    });

    // Handle convert button click
    $("#convertPurchaseOrderBtn").on("click", function () {
        const purchaseId = $(this).data("purchase-id");
        const receivedQuantities = {};

        // Collect all received quantities
        $(".received-qty").each(function () {
            const medicineId = $(this)
                .attr("name")
                .match(/\[(\d+)\]/)[1];
            const receivedQty = $(this).val();
            const maxQty = $(this).attr("max");
            if (receivedQty > maxQty) {
                showNotification(
                    "Error",
                    "error",
                    `Received quantity for medicine ${medicineId} exceeds the maximum quantity.`
                );
                $(this).focus().addClass("is-invalid");
                return;
            } else {
                receivedQuantities[medicineId] = receivedQty;
            }
        });

        // Send request to convert purchase order
        $.ajax({
            url: base_url + "/purchases/convert/" + purchaseId,
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                received_quantities: receivedQuantities,
            },
            success: function (response) {
                if (response.success) {
                    // Close modal
                    $("#convertPurchaseOrderModal").modal("hide");

                    // Show success message
                    showNotification(
                        "Converting purchase order...",
                        "info",
                        response.message
                    );

                    // Reload page after short delay
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                } else {
                    // Show error in modal
                    $("#convertPurchaseOrderModal .modal-body").prepend(
                        `<div class="alert alert-danger">${response.message}</div>`
                    );
                }
            },
            error: function (error) {
                console.log(error);
                $("#convertPurchaseOrderModal .modal-body").prepend(
                    `<div class="alert alert-danger">Error converting purchase order.</div>`
                );
            },
        });
    });
});
