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

    // Load purchase order details in modal
    $(document).on("click", "#convert-purchase", function () {
        const purchaseId = $(this).data("purchase-id");
        const modal = $("#convertPurchaseOrderModal");
        const modalBody = modal.find(".modal-body");

        // Show loading message is already in the HTML by default

        // Fetch purchase details
        $.ajax({
            url: `${baseUrl}/purchases/get-details/${purchaseId}`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    const purchase = response.data.purchase;
                    const medicines = response.data.medicines;

                    // Build the HTML for the modal content
                    let html = `
                        <form id="convertPurchaseOrderForm">
                            <input type="hidden" name="_token" value="${$(
                                'meta[name="csrf-token"]'
                            ).attr("content")}">
                            <div class="mb-3">
                                <h6>Purchase Order: ${purchase.invoice_no}</h6>
                                <p class="text-muted">Supplier: ${
                                    purchase.supplier.name
                                } | Date: ${new Date(
                        purchase.date
                    ).toLocaleDateString()}</p>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Medicine</th>
                                            <th>Ordered Qty</th>
                                            <th>Received Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    `;

                    // Add rows for each medicine
                    medicines.forEach(function (medicine) {
                        html += `
                            <tr>
                                <td>${medicine.name}</td>
                                <td>${medicine.pivot.quantity} ${
                            medicine.unit ? medicine.unit.name : ""
                        }</td>
                                <td>
                                    <input type="number" class="form-control received-qty" 
                                           name="received_quantities[${
                                               medicine.id
                                           }]" 
                                           value="${medicine.pivot.quantity}" 
                                           min="0" max="${
                                               medicine.pivot.quantity
                                           }" readonly>
                                </td>
                            </tr>
                        `;
                    });

                    html += `
                                    </tbody>
                                </table>
                            </div>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle me-2"></i>
                                Adjust the received quantities if necessary before converting the purchase order.
                            </div>
                        </form>
                    `;

                    // Update modal content
                    modalBody.html(html);
                } else {
                    showNotification(
                        "Error",
                        "error",
                        response.message || "Failed to load purchase details"
                    );
                    modalBody.html(
                        `<div class="alert alert-danger">${
                            response.message ||
                            "Failed to load purchase details"
                        }</div>`
                    );
                }
            },
            error: function (xhr) {
                const errorMsg = xhr.responseJSON
                    ? xhr.responseJSON.message
                    : "Something went wrong while loading the purchase details";
                showNotification("Error", "error", errorMsg);
                modalBody.html(
                    `<div class="alert alert-danger">${errorMsg}</div>`
                );
            },
        });
    });

    // Handle convert purchase order form submission
    $(document).on("click", "#convertPurchaseOrderBtn", function () {
        const button = $(this);
        const modal = $("#convertPurchaseOrderModal");
        const form = $("#convertPurchaseOrderForm");
        const purchaseId = $("#convert-purchase").data("purchase-id");

        // Disable button and show loading state with bootstrap spinner
        button
            .attr("disabled", true)
            .html(
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Converting...'
            );

        // Get form data
        const formData = form.serialize();

        // Submit conversion request
        $.ajax({
            url: `${baseUrl}/purchases/convert/${purchaseId}`,
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    // Show success message
                    showNotification(
                        "Success",
                        "success",
                        "Purchase order converted successfully"
                    );

                    // Close modal after 1 second and reload page
                    setTimeout(function () {
                        modal.modal("hide");
                        window.location.reload();
                    }, 1000);
                } else {
                    // Show error message
                    showNotification(
                        "Error",
                        "error",
                        response.message || "Failed to convert purchase order"
                    );
                    button.attr("disabled", false).html("Convert");
                }
            },
            error: function (xhr) {
                const errorMsg = xhr.responseJSON
                    ? xhr.responseJSON.message
                    : "Something went wrong while converting the purchase order";
                showNotification("Error", "error", errorMsg);
                button.attr("disabled", false).html("Convert");
            },
        });
    });

    // Display confirmation before closing modal if form has changed
    $(document).on("input", ".received-qty", function () {
        $(this).data("changed", true);
    });

    $(document).on("hide.bs.modal", "#convertPurchaseOrderModal", function (e) {
        const hasChanges =
            $(".received-qty").filter(function () {
                return $(this).data("changed") === true;
            }).length > 0;

        if (
            hasChanges &&
            !confirm(
                "You have unsaved changes. Are you sure you want to close?"
            )
        ) {
            e.preventDefault();
        }
    });
});
