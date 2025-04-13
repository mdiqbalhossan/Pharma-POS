$(document).ready(function () {
    const baseUrl = $("#base-url").attr("content");
    let currency = $("#currency").val();

    // Initialize Summernote
    $("#summernote").summernote({
        height: 100,
        toolbar: [
            ["style", ["bold", "italic", "underline", "clear"]],
            ["para", ["ul", "ol"]],
            ["height", ["height"]],
        ],
    });

    // Medicine search with Select2 AJAX
    $("#medicine_search")
        .autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseUrl + "/medicines-search", // The URL to your backend script
                    type: "GET",
                    data: { term: request.term }, // Send input value as "term"
                    dataType: "json",
                    success: function (data) {
                        response(data); // Pass the data to the autocomplete widget
                    },
                });
            },
            minLength: 2, // Minimum characters before triggering the search
            select: function (event, ui) {
                addMedicineToTable(ui.item.medicine);
                $(this).val("");
                return false;
            },
        })
        .autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
            .append(
                `<div class="search-item d-flex align-items-center gap-2">
                    <div class="item-img">
                        <img src="${item.medicine.image}" alt="${item.medicine.name}" width="50">
                    </div>
                    <div class="item-info">
                        <p class="mb-0">${item.medicine.name}</p>
                        <p class="mb-0"><small>${item.medicine.generic_name}</small></p>
                    </div>
                </div>`
            )
            .appendTo(ul);
    };

    // Function to add medicine to table
    function addMedicineToTable(medicine) {
        // Check if medicine already exists in the table
        if (
            $('#purchase-table tr[data-medicine-id="' + medicine.id + '"]')
                .length > 0
        ) {
            // Update quantity of existing row instead of adding new one
            const existingRow = $(
                '#purchase-table tr[data-medicine-id="' + medicine.id + '"]'
            );
            const qtyInput = existingRow.find(".medicine-qty");
            qtyInput.val(parseInt(qtyInput.val()) + 1);
            updateRowCalculations(existingRow);
            calculateTotals();
            return;
        }

        const now = new Date();
        const oneYearLater = new Date(now);
        oneYearLater.setFullYear(now.getFullYear() + 1);
        const defaultExpiryDate = oneYearLater.toISOString().slice(0, 10);

        const newRow = `
            <tr data-medicine-id="${medicine.id}">
                <td>
                    ${medicine.name}
                    <input type="hidden" name="medicine_id[]" value="${
                        medicine.id
                    }">
                </td>
                <td>
                    <input type="text" class="form-control batch-no w-150px" name="batch_no[]" required>
                </td>
                <td>
                    <input type="date" class="form-control expiry-date" name="expiry_date[]" value="${defaultExpiryDate}" required>
                </td>
                <td>
                    <input type="number" class="form-control medicine-qty w-100px" name="quantity[]" value="1" min="1" required>
                </td>
                <td>
                    <input type="number" step="0.01" class="form-control sale-price w-100px" name="sale_price[]" value="${
                        medicine.sale_price
                    }" required>
                </td>
                <td>
                    <input type="number" step="0.01" class="form-control unit-price w-100px" name="unit_price[]" value="${
                        medicine.purchase_price
                    }" required>
                </td>
                <td>
                    <input type="number" step="0.01" class="form-control discount w-100px" name="discount[]" value="${
                        medicine.discount_percentage
                    }">
                </td>
                <td>
                    <input type="number" step="0.01" class="form-control tax w-100px" name="tax[]" value="${
                        medicine.vat_percentage || 0
                    }">
                </td>
                <td>
                    <span class="tax-amount">${currency} 0.00</span>
                    <input type="hidden" name="tax_amount[]" class="tax-amount-input" value="0">
                </td>
                <td>
                    <span class="subtotal">${currency} 0.00</span>
                    <input type="hidden" name="subtotal[]" class="subtotal-input" value="0">
                </td>
                <td>
                    <span class="row-total">${currency} 0.00</span>
                    <input type="hidden" name="row_total[]" class="row-total-input" value="0">
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-medicine">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        $("#purchase-table tbody").append(newRow);

        // Update calculations for the new row
        updateRowCalculations($("#purchase-table tr:last"));
        calculateTotals();

        // Initialize the datepicker for the new row
        $(".expiry-date").datetimepicker({
            format: "DD-MM-YYYY",
            icons: {
                up: "fas fa-angle-up",
                down: "fas fa-angle-down",
                next: "fas fa-angle-right",
                previous: "fas fa-angle-left",
            },
        });
    }

    // Remove medicine from table
    $(document).on("click", ".remove-medicine", function () {
        $(this).closest("tr").remove();
        calculateTotals();
    });

    // Update calculations when inputs change
    $(document).on(
        "input",
        ".medicine-qty, .unit-price, .discount, .tax",
        function () {
            updateRowCalculations($(this).closest("tr"));
            calculateTotals();
        }
    );

    // Update order level calculations
    $(document).on(
        "input",
        "#order_tax, #order_discount, #shipping_cost",
        function () {
            calculateTotals();
        }
    );

    // Calculate row totals
    function updateRowCalculations(row) {
        const qty = parseFloat(row.find(".medicine-qty").val()) || 0;
        const unitPrice = parseFloat(row.find(".unit-price").val()) || 0;
        const discountPercent = parseFloat(row.find(".discount").val()) || 0;
        const taxPercent = parseFloat(row.find(".tax").val()) || 0;

        // Calculate subtotal (qty * unitPrice)
        const subtotal = qty * unitPrice;

        // Calculate discount amount based on percentage
        const discountAmount = subtotal * (discountPercent / 100);

        // Calculate tax amount
        const taxAmount = (subtotal - discountAmount) * (taxPercent / 100);

        // Calculate total
        const total = subtotal - discountAmount + taxAmount;

        // Update display values
        row.find(".subtotal").text(currency + " " + subtotal.toFixed(2));
        row.find(".subtotal-input").val(subtotal.toFixed(2));

        row.find(".tax-amount").text(currency + " " + taxAmount.toFixed(2));
        row.find(".tax-amount-input").val(taxAmount.toFixed(2));

        row.find(".row-total").text(currency + " " + total.toFixed(2));
        row.find(".row-total-input").val(total.toFixed(2));
    }

    // Calculate totals for entire purchase
    function calculateTotals() {
        let subtotal = 0;
        let totalTax = 0;
        let totalDiscountAmount = 0;

        // Sum up individual row values
        $("#purchase-table tbody tr").each(function () {
            const rowSubtotal =
                parseFloat($(this).find(".subtotal-input").val()) || 0;
            const discountPercent =
                parseFloat($(this).find(".discount").val()) || 0;
            const discountAmount = rowSubtotal * (discountPercent / 100);

            subtotal += rowSubtotal;
            totalTax +=
                parseFloat($(this).find(".tax-amount-input").val()) || 0;
            totalDiscountAmount += discountAmount;
        });

        // Get order level values
        const orderTax = parseFloat($("#order_tax").val()) || 0;
        const orderDiscount = parseFloat($("#order_discount").val()) || 0;
        const shippingCost = parseFloat($("#shipping_cost").val()) || 0;

        // Calculate additional order tax
        const additionalTax = subtotal * (orderTax / 100);

        // Calculate grand total
        const grandTotal =
            subtotal -
            totalDiscountAmount -
            orderDiscount +
            totalTax +
            additionalTax +
            shippingCost;

        // Update display values
        $("#subtotal-value").text(currency + " " + subtotal.toFixed(2));
        $("#subtotal-input").val(subtotal.toFixed(2));

        $("#tax-value").text(
            currency + " " + (totalTax + additionalTax).toFixed(2)
        );
        $("#tax-input").val((totalTax + additionalTax).toFixed(2));

        $("#discount-value").text(
            currency + " " + (totalDiscountAmount + orderDiscount).toFixed(2)
        );
        $("#discount-input").val(
            (totalDiscountAmount + orderDiscount).toFixed(2)
        );

        $("#grand-total-value").text(currency + " " + grandTotal.toFixed(2));
        $("#grand-total-input").val(grandTotal.toFixed(2));

        // Update due amount based on paid amount
        const paidAmount = parseFloat($("#paid_amount").val()) || 0;
        const dueAmount = grandTotal - paidAmount;

        $("#due-amount-value").text(currency + " " + dueAmount.toFixed(2));
        $("#due_amount").val(dueAmount.toFixed(2));
    }

    // Update due amount when paid amount changes
    $(document).on("input", "#paid_amount", function () {
        calculateTotals();
    });

    // Form Validation
    $("#purchase-form").on("submit", function (e) {
        if ($("#purchase-table tbody tr").length === 0) {
            e.preventDefault();
            toastr.error("Please add at least one medicine to the purchase.");
            return false;
        }

        // Check if supplier is selected
        if (!$("#supplier_id").val()) {
            e.preventDefault();
            toastr.error("Please select a supplier.");
            return false;
        }

        // Validate required fields in medicine rows
        let isValid = true;
        $("#purchase-table tbody tr").each(function () {
            const batchNo = $(this).find(".batch-no").val();
            const expiryDate = $(this).find(".expiry-date").val();

            if (!batchNo || !expiryDate) {
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            toastr.error("Please fill in all required fields for medicines.");
            return false;
        }

        return true;
    });

    // Add supplier from modal
    $(document).on("click", "#add-supplier-btn", function () {
        const name = $("#supplier_name").val();
        const email = $("#supplier_email").val();
        const phone = $("#supplier_phone").val();
        const address = $("#supplier_address").val();

        if (!name) {
            toastr.error("Supplier name is required.");
            return;
        }

        $.ajax({
            url: baseUrl + "/ajax/suppliers/store",
            method: "POST",
            data: {
                name: name,
                email: email,
                phone: phone,
                address: address,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.success) {
                    // Add new option to supplier select
                    const newOption = new Option(
                        response.supplier.name,
                        response.supplier.id,
                        true,
                        true
                    );
                    $("#supplier_id").append(newOption).trigger("change");

                    // Close modal and reset form
                    $("#supplierModal").modal("hide");
                    $("#supplier-form")[0].reset();

                    toastr.success("Supplier added successfully.");
                } else {
                    toastr.error(response.message || "Error adding supplier.");
                }
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function (key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error("Error adding supplier.");
                }
            },
        });
    });

    // Print purchase
    $(document).on("click", "#print-purchase", function () {
        const purchaseId = $(this).data("purchase-id");
        window.open(
            baseUrl + "/purchases/" + purchaseId + "/invoice",
            "_blank"
        );
    });
});
