$(document).ready(function () {
    /**
     * Generate Barcode
     */
    $("#generate-barcode").click(function () {
        let barcode = "";
        for (let i = 0; i < 10; i++) {
            barcode += Math.floor(Math.random() * 10); // Generates a random digit (0-9)
        }
        $("#barcode").val(barcode);
    });

    /**
     * Common function to handle AJAX form submission
     */
    function handleFormSubmit(formId, successCallback) {
        $(`#${formId}`).on("submit", function (e) {
            e.preventDefault();

            const form = $(this);
            const formData = form.serialize();
            const url = form.attr("action");

            // Clear previous error messages
            form.find(".invalid-feedback").hide();
            form.find(".is-invalid").removeClass("is-invalid");
            form.find(".alert").addClass("d-none");

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    // Show success message
                    $(`#${formId}-success-message`)
                        .removeClass("d-none")
                        .text(response.message);

                    // Call the success callback with the response data
                    if (typeof successCallback === "function") {
                        successCallback(response.data);
                    }

                    // Reset the form
                    form[0].reset();

                    // Dismiss the modal after a delay
                    setTimeout(() => {
                        $(`#${formId}`).closest(".modal").modal("hide");
                    }, 1500);
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        // Validation errors
                        const errors = xhr.responseJSON.errors;

                        // Display error messages for each field
                        for (const field in errors) {
                            const errorMsg = errors[field][0];
                            const inputField = form.find(`[name="${field}"]`);

                            inputField.addClass("is-invalid");
                            $(`#${formId}-${field.replace("_", "-")}-error`)
                                .text(errorMsg)
                                .show();
                        }
                    } else {
                        // General error
                        $(`#${formId}-error-message`)
                            .removeClass("d-none")
                            .text("An error occurred. Please try again.");
                    }
                },
            });
        });
    }

    /**
     * Handle Unit modal form submission
     */
    handleFormSubmit("unit-form", function (data) {
        // Add the new unit to the select dropdown
        $("#unit_id").append(new Option(data.name, data.id, true, true));
    });

    /**
     * Handle Medicine Category modal form submission
     */
    handleFormSubmit("category-form", function (data) {
        // Add the new category to the select dropdown
        // Since medicine_categories is a multi-select, we need to create it
        // in a way that it maintains the Select2 functionality
        const newOption = new Option(data.name, data.id, true, true);
        $("#medicine_categories").append(newOption).trigger("change");
    });

    /**
     * Handle Medicine Type modal form submission
     */
    handleFormSubmit("medicine-type-form", function (data) {
        // Add the new medicine type to the select dropdown
        $("#medicine_type_id").append(
            new Option(data.name, data.id, true, true)
        );
    });

    /**
     * Handle Medicine Leaf modal form submission
     */
    handleFormSubmit("medicine-leaf-form", function (data) {
        // Add the new medicine leaf to the select dropdown
        // Format is: type (qty_box)
        const displayText = `${data.type} (${data.qty_box})`;
        $("#medicine_leaf_id").append(
            new Option(displayText, data.id, true, true)
        );
    });

    /**
     * Handle Supplier modal form submission
     */
    handleFormSubmit("supplier-form", function (data) {
        // Add the new supplier to the select dropdown
        $("#supplier_id").append(new Option(data.name, data.id, true, true));
    });

    /**
     * Handle Vendor modal form submission
     */
    handleFormSubmit("vendor-form", function (data) {
        // Add the new vendor to the select dropdown
        $("#vendor_id").append(new Option(data.name, data.id, true, true));
    });
});
