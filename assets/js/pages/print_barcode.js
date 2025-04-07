$(document).ready(function () {
    "use strict";

    let base_url = $("meta[name='base-url']").attr("content");

    // Global variables
    let productsList = [];
    let rowCounter = 0;
    let barcodeTable = $("#barcode-table");

    // Product search using jQuery UI Autocomplete
    $("#medicine_search")
        .autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: base_url + "/search-medicine",
                    dataType: "json",
                    data: {
                        term: request.term,
                    },
                    success: function (data) {
                        response(data);
                    },
                });
            },
            minLength: 2,
            select: function (event, ui) {
                addProduct(ui.item);
                $(this).val("");
                return false;
            },
        })
        .autocomplete("instance")._renderItem = function (ul, item) {
        console.log(item);
        return $("<li>")
            .append(
                `<div class="search-item d-flex align-items-center gap-2">
                    <div class="item-img">
                        <img src="${item.image}" alt="${item.name}" width="50">
                    </div>
                    <div class="item-info">
                        <p class="mb-0">${item.name}</p>
                        <p class="mb-0"><small>${item.generic_name}</small></p>
                    </div>
                </div>`
            )
            .appendTo(ul);
    };

    // Add product to the table
    function addProduct(product) {
        // Check if product already exists in the table
        let existingProduct = productsList.find((p) => p.id === product.id);

        if (existingProduct) {
            // Increment quantity if product already exists
            let rowIndex = productsList.findIndex((p) => p.id === product.id);
            let quantity =
                parseInt($(`#quantity_${existingProduct.rowId}`).val()) + 1;
            $(`#quantity_${existingProduct.rowId}`).val(quantity);

            // Update quantity in the products list
            productsList[rowIndex].quantity = quantity;
        } else {
            // Add new product to the list with a unique row ID
            let rowId = "row_" + rowCounter++;
            product.rowId = rowId;
            product.quantity = 1;
            productsList.push(product);

            // Add row to the table
            let newRow = `
                <tr id="${rowId}">
                    <td>
                        <div class="productimgname">
                            <a href="javascript:void(0);" class="product-img stock-img">
                                <img src="${product.image}" alt="${
                product.name
            }" width="50">
                            </a>
                            <a href="javascript:void(0);">${product.name}</a>
                            <input type="hidden" name="products[${rowId}][id]" value="${
                product.id
            }">
                            <input type="hidden" name="products[${rowId}][name]" value="${
                product.name
            }">
                            <input type="hidden" name="products[${rowId}][image]" value="${
                product.image
            }">
                            <input type="hidden" name="products[${rowId}][price]" value="${
                product.price
            }">
                            <input type="hidden" name="products[${rowId}][generic_name]" value="${
                product.generic_name
            }">
                            <input type="hidden" name="products[${rowId}][barcode]" value="${
                product.barcode
            }">
                        </div>
                    </td>
                    <td>${product.barcode || "-"}</td>
                    <td>
                        <div class="product-quantity">
                            <span class="quantity-btn decrease-btn" data-row-id="${rowId}">
                                <i data-feather="minus-circle" class="feather-minus-circle"></i>
                            </span>
                            <input type="text" class="quntity-input" id="quantity_${rowId}" name="products[${rowId}][quantity]" value="1">
                            <span class="quantity-btn increase-btn" data-row-id="${rowId}">
                                <i data-feather="plus-circle" class="feather-plus-circle"></i>
                            </span>
                        </div>
                    </td>
                    <td class="action-table-data justify-content-center">
                        <div class="edit-delete-action">
                            <a class="confirm-text barcode-delete-icon delete-product" data-row-id="${rowId}" href="javascript:void(0);">
                                <i data-feather="trash-2" class="feather-trash-2"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            `;

            // Add to regular table
            barcodeTable.append(newRow);

            // Reinitialize Feather icons
            if (typeof feather !== "undefined") {
                feather.replace();
            }
        }
    }

    // Handle product deletion
    $(document).on("click", ".delete-product", function () {
        let rowId = $(this).data("row-id");

        // Remove from products list
        productsList = productsList.filter((p) => p.rowId !== rowId);

        // Remove from table
        $(`#${rowId}`).remove();
    });

    // Handle quantity increase
    $(document).on("click", ".increase-btn", function () {
        let rowId = $(this).data("row-id");
        let quantityInput = $(`#quantity_${rowId}`);
        let quantity = parseInt(quantityInput.val()) + 1;

        quantityInput.val(quantity);

        // Update quantity in products list
        let index = productsList.findIndex((p) => p.rowId === rowId);
        if (index !== -1) {
            productsList[index].quantity = quantity;
        }
    });

    // Handle quantity decrease
    $(document).on("click", ".decrease-btn", function () {
        let rowId = $(this).data("row-id");
        let quantityInput = $(`#quantity_${rowId}`);
        let quantity = parseInt(quantityInput.val());

        if (quantity > 1) {
            quantity -= 1;
            quantityInput.val(quantity);

            // Update quantity in products list
            let index = productsList.findIndex((p) => p.rowId === rowId);
            if (index !== -1) {
                productsList[index].quantity = quantity;
            }
        }
    });

    // Handle direct input quantity change
    $(document).on("change", ".quntity-input", function () {
        let id = $(this).attr("id");
        let rowId = id.replace("quantity_", "");
        let quantity = parseInt($(this).val());

        // Ensure quantity is at least 1
        if (isNaN(quantity) || quantity < 1) {
            quantity = 1;
            $(this).val(quantity);
        }

        // Update quantity in products list
        let index = productsList.findIndex((p) => p.rowId === rowId);
        if (index !== -1) {
            productsList[index].quantity = quantity;
        }
    });

    // Reset form
    $("#reset-barcode").on("click", function (e) {
        e.preventDefault();

        // Clear products list
        productsList = [];

        // Clear table
        barcodeTable.find("tbody").empty();

        // Reset form fields
        $("#barcode-form")[0].reset();

        // Reset select2 dropdowns
        $("#vendor_id, #paper_size").val("").trigger("change");
    });

    // Print barcode button
    $("#print-barcode").on("click", function (e) {
        e.preventDefault();

        if (productsList.length === 0) {
            showNotification(
                "Error!",
                "error",
                "Please add at least one product to print barcode"
            );
            return;
        }

        // Submit the form
        $("#barcode-form").submit();
    });

    // Form submission
    $("#barcode-form").on("submit", function (e) {
        if (productsList.length === 0) {
            e.preventDefault();
            showNotification(
                "Error!",
                "error",
                "Please add at least one product to generate barcode"
            );
            return false;
        }

        // Form will submit normally
    });
});
