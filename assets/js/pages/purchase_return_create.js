$(document).ready(function () {
    $(".return-btn").on("click", function () {
        const medicineId = $(this).data("medicine-id");
        const medicineName = $(this).data("medicine-name");
        const purchaseQty = $(this).data("purchase-qty");
        const currentStock = $(this).data("current-stock");
        const unitPrice = $(this).data("unit-price");

        $("#medicine_id").val(medicineId);
        $("#medicine_name").val(medicineName);
        $("#purchase_qty").val(purchaseQty);
        $("#current_stock").val(currentStock);
        $("#unit_price").val(unitPrice);
        $("#display_unit_price").val(unitPrice);

        $("#return-form-container").show();

        // Set max on quantity
        const maxQty = Math.min(purchaseQty, currentStock);
        $("#quantity").attr("max", maxQty);
    });

    // Calculate totals
    $("#quantity, #discount, #tax, #paid_amount").on("input", function () {
        calculateTotals();
    });

    function calculateTotals() {
        const quantity = parseFloat($("#quantity").val()) || 0;
        const unitPrice = parseFloat($("#unit_price").val()) || 0;
        const discount = parseFloat($("#discount").val()) || 0;
        const tax = parseFloat($("#tax").val()) || 0;
        const paidAmount = parseFloat($("#paid_amount").val()) || 0;

        // Calculate total price
        const totalPrice = quantity * unitPrice;
        $("#total_price").val(totalPrice.toFixed(2));

        // Calculate discount amount
        const discountAmount = totalPrice * (discount / 100);

        // Calculate subtotal
        const subtotal = totalPrice - discountAmount;

        // Calculate tax amount
        const taxAmount = subtotal * (tax / 100);

        // Calculate grand total
        const grandTotal = subtotal + taxAmount;
        $("#grand_total").val(grandTotal.toFixed(2));

        // Calculate due amount
        const dueAmount = grandTotal - paidAmount;
        $("#due_amount").val(dueAmount.toFixed(2));
    }

    // Form validation
    $("#return-form").on("submit", function (e) {
        const quantity = parseInt($("#quantity").val()) || 0;
        const purchaseQty = parseInt($("#purchase_qty").val()) || 0;
        const currentStock = parseInt($("#current_stock").val()) || 0;

        if (quantity <= 0) {
            showNotification(
                "Return quantity must be greater than 0",
                "error",
                "Please enter a valid quantity"
            );
            e.preventDefault();
            return false;
        }

        if (quantity > purchaseQty) {
            showNotification(
                "Return quantity cannot be greater than purchased quantity",
                "error",
                "Please enter a valid quantity"
            );
            e.preventDefault();
            return false;
        }

        if (quantity > currentStock) {
            showNotification(
                "Return quantity cannot be greater than current stock",
                "error",
                "Please enter a valid quantity"
            );
            e.preventDefault();
            return false;
        }

        if (!$("#confirmation").is(":checked")) {
            showNotification(
                "Please confirm the return by checking the confirmation box",
                "error",
                "Please enter a valid quantity"
            );
            e.preventDefault();
            return false;
        }

        return true;
    });
});
