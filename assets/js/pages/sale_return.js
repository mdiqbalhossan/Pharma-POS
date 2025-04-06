$(document).ready(function () {
    $(".return-btn").on("click", function () {
        const medicineId = $(this).data("medicine-id");
        const medicineName = $(this).data("medicine-name");
        const soldQty = $(this).data("sold-qty");
        const unitPrice = $(this).data("unit-price");

        $("#medicine_id").val(medicineId);
        $("#medicine_name").val(medicineName);
        $("#sold_qty").val(soldQty);
        $("#unit_price").val(unitPrice);
        $("#display_unit_price").val(unitPrice);

        $("#return-form-container").show();

        // Set max on quantity
        $("#quantity").attr("max", soldQty);
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
        const soldQty = parseInt($("#sold_qty").val()) || 0;

        if (quantity <= 0) {
            alert("Return quantity must be greater than 0");
            e.preventDefault();
            return false;
        }

        if (quantity > soldQty) {
            alert("Return quantity cannot be greater than sold quantity");
            e.preventDefault();
            return false;
        }

        if (!$("#confirmation").is(":checked")) {
            alert("Please confirm the return by checking the confirmation box");
            e.preventDefault();
            return false;
        }

        return true;
    });
});
