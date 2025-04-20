$(document).ready(function () {
    let base_url = $('meta[name="base-url"]').attr("content");
    let currency = $("#currency").val();

    // Initialize the cart from localStorage when page loads
    initCartFromLocalStorage();

    // Initialize sale number
    initSaleNo();

    /**
     * Search Medicine
     */
    $("#search-medicine").on("keyup", function () {
        var search = $(this).val();
        if (search.length > 2) {
            $(".pos_categories_default").addClass("d-none");
            $.ajax({
                url: base_url + "/pos/search",
                type: "GET",
                data: { search: search },
                success: function (response) {
                    $(".pos_products_default").addClass("d-none");
                    $(".pos_products_search").removeClass("d-none");
                    showMedicine(response);
                },
            });
        } else {
            $(".pos_products_default").removeClass("d-none");
            $(".pos_products_search").addClass("d-none");
            $(".pos_categories_default").removeClass("d-none");
        }
    });

    /**
     * Customer Add Form Submission
     */
    $("#customer-form").on("submit", function (e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: base_url + "/pos/customer/store",
            type: "POST",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.success) {
                    // Add the new customer to the select dropdown
                    $(".customer-info select").append(
                        $("<option>", {
                            value: response.customer.id,
                            text: response.customer.name,
                        })
                    );

                    // Select the newly added customer
                    $(".customer-info select")
                        .val(response.customer.id)
                        .trigger("change");

                    // Show success message
                    showPOSNotification(
                        "Success!",
                        "success",
                        response.message
                    );

                    // Clear the form
                    $("#customer-form")[0].reset();

                    // Close the modal
                    $("#create").modal("hide");
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = "";

                for (let field in errors) {
                    errorMessage += errors[field][0] + "\n";
                }

                showPOSNotification("Error!", "error", errorMessage);
            },
        });
    });

    /**
     * Show Medicine
     * @param {Object} medicine
     */
    function showMedicine(medicine) {
        let html = `<div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-3">Products</h5>
                    </div>`;
        html += `<div class="row">`;
        $.each(medicine, function (index, item) {
            html += `
            <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3 pe-2 mb-3">
                <div class="product-info default-cover card" data-id="${
                    item.id
                }">
                    <a href="javascript:void(0);" class="img-bg">
                        <img src="${item.image}" alt="Products">
                        ${
                            item.quantity > 0
                                ? `<span><i data-feather="check" class="feather-16"></i></span>`
                                : `<span class="bg-danger"><i data-feather="x-circle" class="feather-16"></i></span>`
                        }
                    </a>
                    <h6 class="cat-name"><a
                            href="javascript:void(0);">${
                                item.generic_name
                            }</a></h6>
                    <h6 class="product-name"><a
                            href="javascript:void(0);">${item.name}</a></h6>
                    <div class="d-flex align-items-center justify-content-between price">
                        <span>${item.quantity} ${item.unit.name}</span>
                        <p>${currency} ${item.sale_price}</p>
                    </div>
                    
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary mt-2 alternate-med-btn" data-id="${
                    item.id
                }">
                        <i data-feather="repeat" class="feather-14 me-1"></i>Alternatives Medicines
                    </button>
            </div>
            `;
        });
        html += "</div>";
        $(".pos_products_search").html(html);
        feather.replace();
        $(".product-info").on("click", function () {
            let id = $(this).data("id");
            clickOnProductInfo(id);
        });
    }

    /**
     * Click on Medicine
     */
    $(".product-info").on("click", function () {
        let id = $(this).data("id");
        clickOnProductInfo(id);
    });

    /**
     * Function click on product-info
     */
    function clickOnProductInfo(id) {
        // Check if product is already in cart by searching all cart items
        let productExists = false;
        $(".cart-product-item").each(function () {
            if ($(this).data("id") == id) {
                productExists = true;
                return false; // Break the loop
            }
        });

        if (productExists) {
            showPOSNotification(
                "Error!",
                "error",
                "Medicine already in cart. You can update the quantity instead."
            );
            return;
        }
        $.ajax({
            url: base_url + "/pos/medicine/" + id,
            type: "GET",
            success: function (response) {
                let is_prescription_required = response.prescription_required;
                let quantity = response.quantity;

                if (quantity <= 0) {
                    showPOSNotification(
                        "Error!",
                        "error",
                        "Medicine is out of stock"
                    );
                    return;
                }
                if (is_prescription_required) {
                    Swal.fire({
                        title: "Prescription Required",
                        text: "Please check the prescription before adding this medicine to cart.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, check prescription!",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log("showConfirmationModal");
                            addToCart(response);
                            // Add to localStorage
                            addToLocalStorage(response.id, 1);
                            $(".product-wrap .alert").addClass("d-none");
                            updateProductCount();
                            showPOSNotification(
                                "Success!",
                                "success",
                                "Medicine added to cart"
                            );

                            calculateSubTotal();
                            calculateTotal();
                            calculateTax();
                            calculateDiscount();
                        }
                    });
                } else {
                    addToCart(response);
                    // Add to localStorage
                    addToLocalStorage(response.id, 1);
                    $(".product-wrap .alert").addClass("d-none");
                    updateProductCount();
                    showPOSNotification(
                        "Success!",
                        "success",
                        "Medicine added to cart"
                    );

                    calculateSubTotal();
                    calculateTotal();
                    calculateTax();
                    calculateDiscount();
                }
            },
        });
    }

    /**
     * Function to show medicine details
     * @param {Object} medicine
     */
    function addToCart(medicine, quantity = null) {
        let html = `<div class="product-list d-flex align-items-center justify-content-between cart-product-item" data-id="${
            medicine.id
        }">
                            <div class="d-flex align-items-center product-info">
                                <a href="javascript:void(0);" class="img-bg">
                                    <img src="${medicine.image}" alt="Products">
                                </a>
                                <div class="info">
                                    <span>${medicine.generic_name}</span>
                                    <h6><a href="javascript:void(0);">${
                                        medicine.name
                                    }</a></h6>
                                    <p class="sale-price">${
                                        currency + " " + medicine.sale_price
                                    }</p>
                                </div>
                            </div>
                            <div class="qty-item text-center">
                                <a href="javascript:void(0);" class="dec d-flex justify-content-center align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="minus"><i
                                        data-feather="minus-circle" class="feather-14"></i></a>
                                <input type="text" class="form-control text-center qty-item-input" name="qty" value="${
                                    quantity || 1
                                }">
                                <a href="javascript:void(0);" class="inc d-flex justify-content-center align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="plus"><i
                                        data-feather="plus-circle" class="feather-14"></i></a>
                            </div>
                            <div class="d-flex align-items-center action">                                
                                <a class="btn-icon delete-icon confirm-text" href="javascript:void(0);">
                                    <i data-feather="trash-2" class="feather-14"></i>
                                </a>
                            </div>
                        </div>`;
        $(".product-wrap").append(html);
        feather.replace();

        // Focus on the quantity input field of the newly added product
        $(
            ".product-wrap .cart-product-item:last-child .qty-item-input"
        ).focus();

        // All event handlers are now handled with delegation
    }

    /**
     * Function to update value
     */
    function updateValue(element, value) {
        let qty = $(element)
            .closest(".cart-product-item")
            .find(".qty-item-input")
            .val();
        qty = parseInt(qty) + value;
        if (qty < 1) {
            qty = 1;
        }
        let price = $(element)
            .closest(".cart-product-item")
            .find(".sale-price")
            .trim()
            .replace(/[^0-9.-]+/g, "");
        $(element)
            .closest(".cart-product-item")
            .find(".qty-item-input")
            .val(qty);

        // Update localStorage with new quantity
        let id = $(element).closest(".cart-product-item").data("id");
        updateCartItem(id, qty);

        calculateSubTotal();
        calculateTotal();
        calculateTax();
        calculateDiscount();
        calculateShipping();
    }

    // Add event delegation for quantity buttons
    $(".product-wrap").on("click", ".inc", function () {
        updateValue(this, 1);
    });

    $(".product-wrap").on("click", ".dec", function () {
        updateValue(this, -1);
    });

    $(".product-wrap").on("keyup", ".qty-item-input", function () {
        let qty = $(this).val();
        if (qty < 1) {
            $(this).val(1);
            qty = 1;
        }
        updateValue(this, qty);
    });

    // Also use event delegation for delete button
    $(".product-wrap").on("click", ".delete-icon", function () {
        removeSound.play();
        // Remove from localStorage
        let id = $(this).closest(".cart-product-item").data("id");
        removeFromLocalStorage(id);

        $(this).closest(".cart-product-item").remove();
        updateProductCount();
        showPOSNotification("Success!", "success", "Product removed from cart");
        if ($(".cart-product-wrap .cart-product-item").length === 0) {
            $(".cart-product-wrap .alert").removeClass("d-none");
            inputFieldReset();
        }
        calculateSubTotal();
        calculateTotal();
        calculateTax();
        calculateDiscount();
        calculateShipping();
    });

    /**
     * Function to update product count
     */
    function updateProductCount() {
        let count = $(".cart-product-wrap .cart-product-item").length;
        $("#product-count").text(count);
    }

    /**
     * Function to clear cart
     */
    function clearCart() {
        if ($(".cart-product-wrap .cart-product-item").length > 0) {
            $(".cart-product-wrap .cart-product-item").remove();
            // Clear localStorage
            clearCartFromLocalStorage();
            showPOSNotification("Success!", "success", "Cart cleared");
            $(".cart-product-wrap .alert").removeClass("d-none");
            updateProductCount();
        } else {
            showPOSNotification("Error!", "error", "Cart is empty");
        }
        calculateSubTotal();
        calculateTotal();
        calculateTax();
        calculateDiscount();
        calculateShipping();
        inputFieldReset();
    }

    /**
     * Click on Clear Cart
     */
    $("#clear-cart").on("click", function () {
        clearCart();
    });

    /**
     * Calculate All medicine price and add it to sub total
     */
    function calculateSubTotal() {
        let subTotal = 0;
        $(".cart-product-wrap .cart-product-item").each(function () {
            let sale_price = $(this)
                .find(".sale-price")
                .text()
                .trim()
                .replace(/[^0-9.-]+/g, "");
            let qty = $(this).find(".qty-item input").val();
            subTotal += sale_price * qty;
        });
        $("#sub-total").text(numberFormat(subTotal));
    }

    /**
     * Calculate Tax
     */
    function calculateTax() {
        let tax = $("#tax-input").val();
        let subTotal = parseFloat($("#sub-total").text().trim()) || 0;
        let taxAmount = (subTotal * tax) / 100;
        $("#tax").text(numberFormat(taxAmount));
    }

    /**
     * Calculate Discount
     */
    function calculateDiscount() {
        let discount = $("#discount-input").val();
        let subTotal = parseFloat($("#sub-total").text().trim()) || 0;
        let discountAmount = (subTotal * discount) / 100;
        $("#discount").text(numberFormat(discountAmount));
    }

    /**
     * Calculate Total
     */
    function calculateTotal() {
        let subTotal = parseFloat($("#sub-total").text().trim()) || 0;
        let tax = parseFloat($("#tax").text().trim()) || 0;
        let shipping = parseFloat($("#shipping").text().trim()) || 0;
        let discount = parseFloat($("#discount").text().trim()) || 0;
        let total = subTotal + tax + shipping - discount;
        $("#total").text(numberFormat(total));
        $("#grand-total-value").text(numberFormat(total));
    }

    /**
     * Calculate Shipping
     */
    function calculateShipping() {
        let shipping = parseFloat($("#shipping-input").val().trim()) || 0;
        $("#shipping").text(numberFormat(shipping));
    }

    /**
     * On keyup of tax input, shipping input, discount input, calculate tax, shipping, discount and total
     */
    $("#tax-input, #shipping-input, #discount-input").on("keyup", function () {
        calculateTax();
        calculateShipping();
        calculateDiscount();
        calculateTotal();
    });

    /**
     * Function number format
     */
    function numberFormat(number) {
        return number.toFixed(2);
    }

    /**
     * Function input field reset
     */
    function inputFieldReset() {
        $("#tax-input").val(0);
        $("#shipping-input").val(0);
        $("#discount-input").val(0);
    }

    // Add event delegation for quantity input change
    $(".product-wrap").on("change", ".qty-item-input", function () {
        let qty = $(this).val();
        if (qty < 1) {
            $(this).val(1);
            qty = 1;
        }

        // Update localStorage with new quantity
        let id = $(this).closest(".cart-product-item").data("id");
        updateCartItem(id, qty);

        calculateSubTotal();
        calculateTotal();
        calculateTax();
        calculateDiscount();
        calculateShipping();
    });

    /**
     * Cart Item add on local storage
     */
    function addToLocalStorage(id, qty) {
        let cart = localStorage.getItem("cart");
        if (cart) {
            cart = JSON.parse(cart);
        } else {
            cart = [];
        }

        // Check if the item already exists in the cart
        let existingItemIndex = cart.findIndex((item) => item.id === id);
        if (existingItemIndex !== -1) {
            cart[existingItemIndex].qty = qty;
        } else {
            cart.push({ id, qty });
        }

        localStorage.setItem("cart", JSON.stringify(cart));
    }

    /**
     * Get cart item from local storage
     */
    function getCartItem() {
        let cart = localStorage.getItem("cart");
        if (cart) {
            return JSON.parse(cart);
        }
        return [];
    }

    /**
     * Cart Item remove from local storage
     */
    function removeFromLocalStorage(id) {
        let cart = localStorage.getItem("cart");
        if (cart) {
            cart = JSON.parse(cart);
            cart = cart.filter((item) => item.id !== id);
            localStorage.setItem("cart", JSON.stringify(cart));
        }
    }

    /**
     * Cart Item clear from local storage
     */
    function clearCartFromLocalStorage() {
        localStorage.removeItem("cart");
    }

    /**
     * Cart Item update on local storage
     */
    function updateCartItem(id, qty) {
        let cart = localStorage.getItem("cart");
        if (cart) {
            cart = JSON.parse(cart);
            let existingItem = cart.find((item) => item.id === id);
            if (existingItem) {
                existingItem.qty = qty;
                localStorage.setItem("cart", JSON.stringify(cart));
            }
        }
    }

    /**
     * Initialize cart from localStorage when page loads
     */
    function initCartFromLocalStorage() {
        let cartItems = getCartItem();
        if (cartItems.length > 0) {
            // Hide the "no products" message
            $(".product-wrap .alert").addClass("d-none");

            // Load each item into the cart
            cartItems.forEach((item) => {
                $.ajax({
                    url: base_url + "/pos/medicine/" + item.id,
                    type: "GET",
                    async: false, // To ensure items are added in order
                    success: function (response) {
                        addToCart(response);
                        // Update quantity to match localStorage
                        let cartItem = $(
                            `.cart-product-item[data-id="${item.id}"]`
                        );
                        cartItem.find(".qty-item-input").val(item.qty);
                    },
                    error: function () {
                        // If medicine no longer exists, remove it from localStorage
                        removeFromLocalStorage(item.id);
                    },
                });
            });

            // Update counts and calculations
            updateProductCount();
            calculateSubTotal();
            calculateTotal();
            calculateTax();
            calculateDiscount();
            calculateShipping();
        }

        // Initialize payment method from localStorage
        initPaymentMethod();
    }

    /**
     * Initialize payment method from localStorage
     */
    function initPaymentMethod() {
        let paymentMethod = localStorage.getItem("payment_method");
        if (paymentMethod) {
            $(`#payment-${paymentMethod}`).prop("checked", true);
        }
    }

    /**
     * Initialize Sale No
     */
    function initSaleNo() {
        let saleNo = localStorage.getItem("sale_no");
        if (saleNo && saleNo != null) {
            $(".sales_id").text(saleNo);
        } else {
            let existingSaleNo = $(".sales_id").text();
            localStorage.setItem("sale_no", existingSaleNo);
        }
    }

    /**
     * Handle payment method selection
     */
    $(".payment-radio").on("change", function () {
        let paymentMethod = $(this).val();
        localStorage.setItem("payment_method", paymentMethod);
    });

    /**
     * Order button handlers
     */
    // Open order - load order into cart
    $(document).on("click", ".open-order", function () {
        let orderId = $(this).data("id");
        openOrder(orderId);
    });

    // View order products
    $(document).on("click", ".view-products", function () {
        let orderId = $(this).data("id");
        let sameNo = $(this).data("sale-no");
        let saleId = viewOrderProducts(orderId, sameNo);
        $("#recents").modal("hide");
    });

    // Print order receipt
    $(document).on("click", ".print-receipt", function () {
        let orderId = $(this).data("id");
        $("#recents").modal("hide");
        printOrderReceipt(orderId);
    });

    /**
     * Open Order - Add products to cart
     */
    function openOrder(orderId) {
        $.ajax({
            url: base_url + "/sales/" + orderId + "/details",
            type: "GET",
            beforeSend: function () {
                // Clear the cart first
                clearCart();
                showPOSNotification("Info", "info", "Loading order...");
            },
            success: function (response) {
                if (response.success) {
                    const order = response.data;
                    $(".sales_id").text(order.sale_no);
                    // Set customer
                    $(".customer-info select")
                        .val(order.customer_id)
                        .trigger("change");

                    // Set tax, shipping, discount
                    $("#tax-input").val(order.tax_percentage || 0);
                    $("#shipping-input").val(order.shipping_amount || 0);
                    $("#discount-input").val(order.discount_percentage || 0);

                    // Set payment method
                    $(`#payment-${order.payment_method}`)
                        .prop("checked", true)
                        .trigger("change");

                    // Add each medicine to cart
                    order.medicines.forEach(function (medicine) {
                        // Add to cart
                        addToCart(medicine, medicine.pivot.quantity);

                        // Add to localStorage
                        addToLocalStorage(medicine.id, medicine.pivot.quantity);
                        // Update sale no
                        localStorage.setItem("sale_no", order.sale_no);
                    });

                    // Hide the "no products" message
                    $(".product-wrap .alert").addClass("d-none");

                    // Update calculations
                    updateProductCount();
                    calculateSubTotal();
                    calculateTotal();
                    calculateTax();
                    calculateDiscount();
                    calculateShipping();

                    // Close the orders modal
                    $("#orders").modal("hide");

                    showPOSNotification(
                        "Success!",
                        "success",
                        "Order loaded successfully"
                    );
                }
            },
            error: function (xhr) {
                showPOSNotification("Error!", "error", "Failed to load order");
            },
        });
    }

    /**
     * View Order Products
     */
    function viewOrderProducts(orderId, sale_no) {
        $("#products").modal("show");
        $.ajax({
            url: base_url + "/sales/" + orderId + "/products",
            type: "GET",
            beforeSend: function () {
                // Show loading
                $("#product-order-id").text("#" + sale_no);
                $("#order-products-container").html(`
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p>Loading products...</p>
                    </div>
                `);
                $("#products").modal("show");
            },
            success: function (response) {
                if (response.success) {
                    const products = response.data;
                    let html = "";

                    products.forEach(function (product, index) {
                        html += `
                        <div class="product-list d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center flex-fill">
                                <a href="javascript:void(0);" class="img-bg me-2">
                                    <img src="${product.image}" alt="Products" style="width: 50px; height: 50px;">
                                </a>
                                <div class="info d-flex align-items-center justify-content-between flex-fill">
                                    <div>
                                        <span>${product.generic_name}</span>
                                        <h6><a href="javascript:void(0);">${product.name}</a></h6>
                                    </div>
                                    <p>${currency} ${product.sale_price}</p>
                                </div>
                            </div>
                            <div class="quantity ms-3">
                                <span class="badge bg-info">${product.pivot.quantity} pcs</span>
                            </div>
                        </div>
                        `;
                    });

                    if (products.length === 0) {
                        html =
                            '<div class="alert alert-warning">No products found in this order</div>';
                    }

                    $("#order-products-container").html(html);
                }
            },
            error: function (xhr) {
                $("#order-products-container").html(
                    '<div class="alert alert-danger">Failed to load products</div>'
                );
            },
        });

        $("#orders").modal("hide");
    }

    /**
     * Print Order Receipt
     */
    function printOrderReceipt(orderId) {
        $.ajax({
            url: base_url + "/sales/" + orderId + "/receipt",
            type: "GET",
            beforeSend: function () {
                // Show loading
                $("#receipt-content").html(`
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p>Loading receipt...</p>
                    </div>
                `);
                $("#print-receipt").modal("show");
            },
            success: function (response) {
                if (response.success) {
                    const order = response.data;

                    // Get receipt template
                    let receiptTemplate = $("#receipt-template").html();
                    $("#receipt-content").html(receiptTemplate);

                    // Fill customer details
                    $("#customer-name").text(order.customer.name);
                    $("#invoice-no").text("#" + order.sale_no);
                    $("#customer-id").text("#" + order.customer.id);
                    $("#invoice-date").text(order.sale_date);

                    // Fill items
                    let itemsHtml = "";
                    order.medicines.forEach(function (medicine, index) {
                        itemsHtml += `
                        <tr>
                            <td>${index + 1}. ${medicine.name}</td>
                            <td>${currency} ${medicine.pivot.price}</td>    
                            <td>${medicine.pivot.quantity}</td>
                            <td class="text-end">${currency} ${
                            medicine.pivot.total
                        }</td>
                        </tr>
                        `;
                    });
                    $("#receipt-items").html(itemsHtml);

                    // Fill totals
                    $("#receipt-subtotal").text(
                        currency + " " + order.total_amount
                    );
                    $("#receipt-discount").text(
                        "-" + currency + " " + order.discount_amount
                    );
                    $("#receipt-shipping").text(
                        currency + " " + order.shipping_amount
                    );
                    $("#receipt-tax").text(currency + " " + order.tax_amount);
                    $("#receipt-total").text(
                        currency + " " + order.grand_total
                    );
                    $("#receipt-due").text(currency + " " + order.amount_due);
                    $("#receipt-payable").text(
                        currency + " " + order.grand_total
                    );
                    $("#receipt-sale-no").text(order.sale_no);
                    $("#receipt-barcode").html(order.barcode);

                    // Handle print button
                    $(".print-button").on("click", function () {
                        printReceipt();
                    });
                }
            },
            error: function (xhr) {
                $("#receipt-content").html(
                    '<div class="alert alert-danger">Failed to load receipt</div>'
                );
            },
        });

        $("#orders").modal("hide");
    }

    /**
     * Print receipt function
     */
    function printReceipt() {
        let printContents =
            document.getElementById("receipt-content").innerHTML;
        let originalContents = document.body.innerHTML;

        // Add afterprint event listener before printing
        window.addEventListener(
            "afterprint",
            function () {
                // Reload the page after printing is complete or canceled
                window.location.reload();
            },
            { once: true }
        );

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

        // Reattach event handlers after reprinting the body
        attachEventHandlers();
    }

    /**
     * Payment Modal Functionality
     */

    // Show payment modal with current total
    $("#payment-btn").on("click", function () {
        if ($(".cart-product-wrap .cart-product-item").length === 0) {
            showPOSNotification("Error!", "error", "Cart is empty");
            return false;
        }
        $("#payment-modal").modal("show");
        let grandTotal = parseFloat($("#grand-total-value").text().trim()) || 0;
        $("#payment-grand-total").val(numberFormat(grandTotal));
        $("#payment-amount-received").val("");
        $("#payment-change-amount").text("0.00");
        $("#payment-note").val("");
    });

    // Quick amount buttons
    $(".quick-amount").on("click", function () {
        let amount = parseFloat($(this).data("amount"));
        $("#payment-amount-received").val(amount);
        calculateChange();
    });

    // Calculate change when amount received is entered
    $("#payment-amount-received").on("input", function () {
        calculateChange();
    });

    // Calculate change amount
    function calculateChange() {
        let grandTotal = parseFloat($("#payment-grand-total").val()) || 0;
        let amountReceived =
            parseFloat($("#payment-amount-received").val()) || 0;
        let changeAmount = amountReceived - grandTotal;

        if (changeAmount >= 0) {
            $("#payment-change-amount").text(numberFormat(changeAmount));
        } else {
            $("#payment-change-amount").text("0.00");
        }
    }

    // Complete sale button
    $("#complete-sale-btn").on("click", function () {
        let grandTotal = parseFloat($("#payment-grand-total").val()) || 0;
        let amountReceived =
            parseFloat($("#payment-amount-received").val()) || 0;

        if (amountReceived < grandTotal) {
            showPOSNotification(
                "Error!",
                "error",
                "Amount received must be greater than or equal to total amount"
            );
            return;
        }

        // Get all cart items
        let cartItems = [];
        $(".cart-product-wrap .cart-product-item").each(function () {
            let id = $(this).data("id");
            let qty = $(this).find(".qty-item-input").val();
            let price = parseFloat(
                $(this)
                    .find(".sale-price")
                    .text()
                    .trim()
                    .replace(/[^0-9.-]+/g, "")
            );
            let total = qty * price;

            cartItems.push({
                id: id,
                quantity: qty,
                price: price,
                total: total,
            });
        });
        let saleNo = $(".sales_id").text().trim();

        // Prepare sale data
        let saleData = {
            customer_id: $(".customer-info select").val(),
            sale_no: saleNo,
            sale_date: new Date().toISOString().split("T")[0],
            tax_percentage: $("#tax-input").val() || 0,
            discount_percentage: $("#discount-input").val() || 0,
            shipping_amount: $("#shipping-input").val() || 0,
            tax_amount: parseFloat($("#tax").text()) || 0,
            discount_amount: parseFloat($("#discount").text()) || 0,
            total_amount: parseFloat($("#sub-total").text()) || 0,
            grand_total: grandTotal,
            amount_paid: grandTotal,
            amount_due: 0, // Fully paid
            payment_method: $('input[name="payment-method"]:checked').val(),
            payment_status: "paid",
            status: "success",
            note: $("#payment-note").val(),
            medicines: cartItems,
        };

        // Send AJAX request
        $.ajax({
            url: base_url + "/sales",
            type: "POST",
            data: saleData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function () {
                $("#complete-sale-btn")
                    .prop("disabled", true)
                    .html(
                        '<i class="spinner-border spinner-border-sm"></i> Processing...'
                    );
            },
            success: function (response) {
                // Close the payment modal
                $("#payment-modal").modal("hide");

                // Show the payment completed modal
                $("#payment-completed").modal("show");
                // Set data-id on the print receipt button - update to target specific button in the modal
                $("#payment-completed .print-receipt").attr(
                    "data-id",
                    response.data.id
                );

                // Clear the cart
                clearCart();

                // Clear localStorage
                clearCartFromLocalStorage();

                // Reset the sale number
                localStorage.removeItem("sale_no");

                // Reset calculation info
                resetCalculationInfo();

                // Enable the button again
                $("#complete-sale-btn")
                    .prop("disabled", false)
                    .html(
                        '<i data-feather="check-circle" class="feather-16 me-1"></i> Complete Sale'
                    );
                feather.replace();

                showPOSNotification(
                    "Success!",
                    "success",
                    "Sale completed successfully"
                );
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = "";

                for (let field in errors) {
                    errorMessage += errors[field][0] + "\n";
                }

                showPOSNotification("Error!", "error", errorMessage);
                $("#complete-sale-btn")
                    .prop("disabled", false)
                    .html(
                        '<i data-feather="check-circle" class="feather-16 me-1"></i> Complete Sale'
                    );
                feather.replace();
            },
        });
    });

    // New transaction button
    $("#new-transaction-btn").on("click", function () {
        // Close the modal
        $("#payment-completed").modal("hide");

        // Reload the page to get a new sale number
        window.location.reload();
    });

    /**
     * Reattach event handlers after printing
     */
    function attachEventHandlers() {
        // Reattach all event handlers here
        $("#search-medicine").on("keyup", function () {});

        // Add other event handlers as needed

        // Reinitialize feather icons
        if (typeof feather !== "undefined") {
            feather.replace();
        }
    }

    /**
     * Style the payment options for better UX
     */
    $(".payment-option").each(function () {
        const radio = $(this).find(".payment-radio");
        const label = $(this).find("label");

        // Hide the actual radio button but keep it functional
        radio.css({
            position: "absolute",
            opacity: "0",
            width: "100%",
            height: "100%",
            cursor: "pointer",
            "z-index": "1",
        });

        // Add active class to the selected payment method
        if (radio.is(":checked")) {
            $(this).addClass("active-payment");
        }

        // Update active class on change
        radio.on("change", function () {
            $(".payment-option").removeClass("active-payment");
            if ($(this).is(":checked")) {
                $(this).closest(".payment-option").addClass("active-payment");
            }
        });
    });

    /**
     * Hold Order
     */
    $(".hold-order").on("click", function () {
        if ($(".cart-product-item").length === 0) {
            showPOSNotification("Error!", "error", "Cart is empty");
            return;
        }
        $("#hold-order").modal("show");
        let grandTotal = parseFloat($("#grand-total-value").text().trim()) || 0;
        let referenceNumber = randomNumber(6);
        $("#hold-total").text(numberFormat(grandTotal));
        $("#hold-reference").val(referenceNumber);
    });

    /**
     * Void Order
     */
    $(".void-order").on("click", function () {
        if ($(".cart-product-item").length === 0) {
            showPOSNotification("Error!", "error", "Cart is empty");
            return;
        }

        // Use SweetAlert instead of native confirm
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to cancel this order?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, cancel it!",
        }).then((result) => {
            if (result.isConfirmed) {
                // Get all cart items
                let cartItems = [];
                $(".cart-product-wrap .cart-product-item").each(function () {
                    let id = $(this).data("id");
                    let qty = $(this).find(".qty-item-input").val();
                    let price = parseFloat(
                        $(this)
                            .find(".sale-price")
                            .text()
                            .trim()
                            .replace(/[^0-9.-]+/g, "")
                    );
                    let total = qty * price;

                    cartItems.push({
                        id: id,
                        quantity: qty,
                        price: price,
                        total: total,
                    });
                });
                let saleNo = $(".sales_id").text().trim();
                // Prepare sale data
                let saleData = {
                    customer_id: $(".customer-info select").val(),
                    sale_no: saleNo,
                    sale_date: new Date().toISOString().split("T")[0],
                    tax_percentage: $("#tax-input").val() || 0,
                    discount_percentage: $("#discount-input").val() || 0,
                    shipping_amount: $("#shipping-input").val() || 0,
                    tax_amount: parseFloat($("#tax").text()) || 0,
                    discount_amount: parseFloat($("#discount").text()) || 0,
                    total_amount: parseFloat($("#sub-total").text()) || 0,
                    grand_total:
                        parseFloat($("#grand-total-value").text()) || 0,
                    amount_paid: 0,
                    amount_due: parseFloat($("#grand-total-value").text()) || 0,
                    payment_method: $(
                        "input[name='payment-method']:checked"
                    ).val(),
                    payment_status: "unpaid",
                    status: "cancelled",
                    note: "Order was voided",
                    medicines: cartItems,
                };

                // Send AJAX request
                $.ajax({
                    url: base_url + "/sales",
                    type: "POST",
                    data: saleData,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (response) {
                        // Show success notification
                        showPOSNotification(
                            "Success!",
                            "success",
                            "Order has been cancelled successfully"
                        );

                        // Clear the cart
                        clearCart();

                        // Clear localStorage
                        clearCartFromLocalStorage();

                        // Clear the order id
                        localStorage.removeItem("sale_no");

                        // Reload the page
                        window.location.reload();
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = "";

                        for (let field in errors) {
                            errorMessage += errors[field][0] + "\n";
                        }

                        showPOSNotification("Error!", "error", errorMessage);
                    },
                });
            }
        });
    });

    /**
     * Hold Order Form Submission
     */
    $("#hold-order-form").on("submit", function (e) {
        e.preventDefault();

        // Get all cart items
        let cartItems = [];
        $(".cart-product-wrap .cart-product-item").each(function () {
            let id = $(this).data("id");
            let qty = $(this).find(".qty-item-input").val();
            let price = parseFloat(
                $(this)
                    .find(".sale-price")
                    .text()
                    .trim()
                    .replace(/[^0-9.-]+/g, "")
            );
            let total = qty * price;

            cartItems.push({
                id: id,
                quantity: qty,
                price: price,
                total: total,
            });
        });
        // Prepare sale data
        let saleData = {
            customer_id: $(".customer-info select").val(),
            sale_no: $(".sales_id").text() || $("#hold-reference").val(),
            sale_date: new Date().toISOString().split("T")[0],
            tax_percentage: $("#tax-input").val() || 0,
            discount_percentage: $("#discount-input").val() || 0,
            shipping_amount: $("#shipping-input").val() || 0,
            tax_amount: parseFloat($("#tax").text()) || 0,
            discount_amount: parseFloat($("#discount").text()) || 0,
            total_amount: parseFloat($("#sub-total").text()) || 0,
            grand_total: parseFloat($("#grand-total-value").text()) || 0,
            amount_paid: 0,
            amount_due: parseFloat($("#grand-total-value").text()) || 0,
            payment_method: $("input[name='payment-method']:checked").val(),
            payment_status: "unpaid",
            status: "pending",
            note: "Order placed on hold",
            medicines: cartItems,
        };

        // Send AJAX request
        $.ajax({
            url: base_url + "/sales",
            type: "POST",
            data: saleData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // Show success notification
                showPOSNotification(
                    "Success!",
                    "success",
                    "Order has been placed on hold successfully"
                );

                // Clear the cart
                clearCart();

                // Clear localStorage
                clearCartFromLocalStorage();

                // Close the hold order modal
                $("#hold-order").modal("hide");

                // Reset the form
                $("#hold-order-form")[0].reset();
                // Reset calculation info
                resetCalculationInfo();
                // Reset sale no
                localStorage.removeItem("sale_no");

                window.location.reload();
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = "";

                for (let field in errors) {
                    errorMessage += errors[field][0] + "\n";
                }

                showPOSNotification("Error!", "error", errorMessage);
            },
        });
    });

    /**
     * Function to generate random number
     */
    function randomNumber(length) {
        return Math.floor(
            Math.pow(10, length - 1) +
                Math.random() *
                    (Math.pow(10, length) - Math.pow(10, length - 1) - 1)
        );
    }

    /**
     * Reset CalculationInfo
     */

    function resetCalculationInfo() {
        $("#sub-total").text(0);
        $("#tax").text(0);
        $("#shipping").text(0);
        $("#discount").text(0);
        $("#total").text(0);
        $("#grand-total-value").text(0);
    }

    /**
     * Reset Button Click Event
     */
    $("#reset-pos").on("click", function () {
        // Clear the cart
        clearCart();

        // Clear localStorage completely
        clearCartFromLocalStorage();
        localStorage.removeItem("payment_method");
        localStorage.removeItem("sale_no");

        // Reset customer selection to default (walk-in customer)
        $(".customer-info select").val(0).trigger("change");

        // Reset all calculation fields
        resetCalculationInfo();

        // Reset input fields
        inputFieldReset();

        // Show success notification
        showPOSNotification("Success!", "success", "POS system has been reset");

        // Reload the sale number
        window.location.reload();
    });

    /**
     * Orders Search Functionality
     */
    // Initialize search inputs for each tab in the orders modal
    $(document).ready(function () {
        // Add the search input fields to all search areas in the orders modal
        $(".search-order .search-input").each(function () {
            // Keep the search button but add an input field before it
            let searchButton = $(this).find(".btn-searchset");
            $(this).html(
                '<input type="text" class="form-control order-search-input" placeholder="Search by order ID, customer...">'
            );
            $(this).append(searchButton);
        });

        // Handle search input for orders
        $(".order-search-input").on("keyup", function () {
            let searchTerm = $(this).val().toLowerCase().trim();
            // Get the active tab ID to know which orders to search
            let activeTabId = $(".tab-pane.active").attr("id");

            // Only search if we have at least 2 characters
            if (searchTerm.length >= 2) {
                // Show loading indicator in the active tab
                $("#" + activeTabId + " .order-body").html(`
                    <div class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Searching orders...</p>
                    </div>
                `);

                // Make AJAX request to search orders
                $.ajax({
                    url: base_url + "/pos/search-orders",
                    type: "GET",
                    data: {
                        search: searchTerm,
                        status: activeTabId, // Pass the active tab as status (onhold, unpaid, paid, cancelled)
                    },
                    success: function (response) {
                        if (response.success) {
                            if (response.orders.length === 0) {
                                $("#" + activeTabId + " .order-body").html(`
                                    <div class="alert alert-warning">No orders found matching "${searchTerm}"</div>
                                `);
                            } else {
                                let html = "";

                                // Loop through orders and create HTML
                                $.each(
                                    response.orders,
                                    function (index, order) {
                                        // Set badge class based on status
                                        let badgeClass = "bg-secondary";
                                        if (activeTabId === "unpaid")
                                            badgeClass = "bg-info";
                                        if (activeTabId === "paid")
                                            badgeClass = "bg-primary";
                                        if (activeTabId === "cancelled")
                                            badgeClass = "bg-danger";

                                        html += `
                                    <div class="default-cover p-4 mb-4">
                                        <span class="badge ${badgeClass} d-inline-block mb-4">Order ID : #${order.sale_no}</span>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr class="mb-3">
                                                        <td>Cashier</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">${order.user.name}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Customer</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">${order.customer.name}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">${order.grand_total}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">${order.sale_date}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>`;

                                        // Only show note for active orders (not cancelled)
                                        if (activeTabId !== "cancelled") {
                                            html += `<p class="p-4">Customer need to recheck the product once</p>`;
                                        }

                                        // Add buttons based on tab
                                        html += `<div class="btn-row d-flex align-items-center justify-content-between">`;

                                        // Show "Open" button for onhold and unpaid orders
                                        if (
                                            activeTabId === "onhold" ||
                                            activeTabId === "unpaid"
                                        ) {
                                            html += `<a href="javascript:void(0);" class="btn btn-info btn-icon flex-fill open-order" data-id="${order.id}">Open</a>`;
                                        }

                                        // Show "Products" button for all orders
                                        html += `<a href="javascript:void(0);" class="btn btn-danger btn-icon flex-fill view-products" data-id="${order.id}" data-sale-no="${order.sale_no}">Products</a>`;

                                        // Show "Print" button for all except cancelled orders
                                        if (activeTabId !== "cancelled") {
                                            html += `<a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill print-receipt" data-id="${order.id}">Print</a>`;
                                        }

                                        html += `</div></div>`;
                                    }
                                );

                                $("#" + activeTabId + " .order-body").html(
                                    html
                                );

                                // Reattach event handlers for buttons
                                $(".open-order").on("click", function () {
                                    let orderId = $(this).data("id");
                                    openOrder(orderId);
                                });

                                $(".view-products").on("click", function () {
                                    let orderId = $(this).data("id");
                                    let saleNo = $(this).data("sale-no");
                                    viewOrderProducts(orderId, saleNo);
                                });

                                $(".print-receipt").on("click", function () {
                                    let orderId = $(this).data("id");
                                    printOrderReceipt(orderId);
                                });
                            }
                        } else {
                            $("#" + activeTabId + " .order-body").html(`
                                <div class="alert alert-danger">${
                                    response.message ||
                                    "An error occurred while searching"
                                }</div>
                            `);
                        }
                    },
                    error: function (xhr) {
                        $("#" + activeTabId + " .order-body").html(`
                            <div class="alert alert-danger">Error: Could not search orders</div>
                        `);
                    },
                });
            } else if (searchTerm.length === 0) {
                // If search is cleared, reload the original tab content
                $.ajax({
                    url: base_url + "/pos/get-orders",
                    type: "GET",
                    data: {
                        status: activeTabId,
                    },
                    success: function (response) {
                        if (response.success) {
                            if (response.orders.length === 0) {
                                $("#" + activeTabId + " .order-body").html(`
                                    <div class="alert alert-warning">No orders found</div>
                                `);
                            } else {
                                let html = "";

                                // Loop through orders and create HTML (same as search results)
                                $.each(
                                    response.orders,
                                    function (index, order) {
                                        // Set badge class based on status
                                        let badgeClass = "bg-secondary";
                                        if (activeTabId === "unpaid")
                                            badgeClass = "bg-info";
                                        if (activeTabId === "paid")
                                            badgeClass = "bg-primary";
                                        if (activeTabId === "cancelled")
                                            badgeClass = "bg-danger";

                                        html += `
                                    <div class="default-cover p-4 mb-4">
                                        <span class="badge ${badgeClass} d-inline-block mb-4">Order ID : #${order.sale_no}</span>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr class="mb-3">
                                                        <td>Cashier</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">${order.user.name}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Customer</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">${order.customer.name}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">${order.grand_total}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">${order.sale_date}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>`;

                                        // Only show note for active orders (not cancelled)
                                        if (activeTabId !== "cancelled") {
                                            html += `<p class="p-4">Customer need to recheck the product once</p>`;
                                        }

                                        // Add buttons based on tab
                                        html += `<div class="btn-row d-flex align-items-center justify-content-between">`;

                                        // Show "Open" button for onhold and unpaid orders
                                        if (
                                            activeTabId === "onhold" ||
                                            activeTabId === "unpaid"
                                        ) {
                                            html += `<a href="javascript:void(0);" class="btn btn-info btn-icon flex-fill open-order" data-id="${order.id}">Open</a>`;
                                        }

                                        // Show "Products" button for all orders
                                        html += `<a href="javascript:void(0);" class="btn btn-danger btn-icon flex-fill view-products" data-id="${order.id}" data-sale-no="${order.sale_no}">Products</a>`;

                                        // Show "Print" button for all except cancelled orders
                                        if (activeTabId !== "cancelled") {
                                            html += `<a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill print-receipt" data-id="${order.id}">Print</a>`;
                                        }

                                        html += `</div></div>`;
                                    }
                                );

                                $("#" + activeTabId + " .order-body").html(
                                    html
                                );

                                // Reattach event handlers for buttons
                                $(".open-order").on("click", function () {
                                    let orderId = $(this).data("id");
                                    openOrder(orderId);
                                });

                                $(".view-products").on("click", function () {
                                    let orderId = $(this).data("id");
                                    let saleNo = $(this).data("sale-no");
                                    viewOrderProducts(orderId, saleNo);
                                });

                                $(".print-receipt").on("click", function () {
                                    let orderId = $(this).data("id");
                                    printOrderReceipt(orderId);
                                });
                            }
                        }
                    },
                    error: function (xhr) {
                        $("#" + activeTabId + " .order-body").html(`
                            <div class="alert alert-danger">Error: Could not load orders</div>
                        `);
                    },
                });
            }
        });

        // Handle tab changes to reset search
        $('button[data-bs-toggle="tab"]').on("shown.bs.tab", function (e) {
            // Clear search inputs when changing tabs
            $(".order-search-input").val("");
        });
    });
    let soundBody = $("body");
    // Work with media
    let cartSound = new Howl({
        src: [base_url + "/assets/media/click.wav"],
    });

    let removeSound = new Howl({
        src: [base_url + "/assets/media/erase.wav"],
    });

    // Play sound when adding to cart
    soundBody.on("click", ".product-info", function () {
        cartSound.play();
    });

    // Play sound when erase cart
    soundBody.on("click", "#clear-cart", function () {
        removeSound.play();
    });

    /**
     * Alternate Medicine Functionality
     */

    // Delegate click event for alternate medicine buttons
    $(document).on("click", ".alternate-med-btn", function (e) {
        e.stopPropagation(); // Prevent the medicine card click

        const medicineId = $(this).data("id");

        // Show the modal
        $("#alternate-medicines").modal("show");

        // Reset the containers
        $(".selected-medicine").html("");
        $(".alternate-medicines-container").html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading alternate medicines...</p>
            </div>
        `);

        // Fetch alternate medicines
        $.ajax({
            url: base_url + "/pos/alternate-medicines/" + medicineId,
            type: "GET",
            success: function (response) {
                if (response.success) {
                    // Display the original medicine
                    const medicine = response.medicine;
                    const originalMedicineHtml = `
                        <div class="product-list d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center flex-fill">
                                <a href="javascript:void(0);" class="img-bg me-2">
                                    <img src="${
                                        medicine.image
                                    }" alt="Medicine" style="width: 50px; height: 50px;">
                                </a>
                                <div class="info d-flex align-items-center justify-content-between flex-fill">
                                    <div>
                                        <span>${medicine.generic_name}</span>
                                        <h6><a href="javascript:void(0);">${
                                            medicine.name
                                        }</a></h6>
                                    </div>
                                    <p>${currency} ${medicine.sale_price}</p>
                                </div>
                            </div>
                            <div class="quantity ms-3">
                                <span class="badge ${
                                    medicine.quantity > 0
                                        ? "bg-success"
                                        : "bg-danger"
                                }">${medicine.quantity} ${
                        medicine.unit?.name || "pcs"
                    }</span>
                            </div>
                        </div>
                    `;
                    $(".selected-medicine").html(originalMedicineHtml);

                    // Display alternate medicines
                    const alternates = response.alternates;
                    if (alternates.length === 0) {
                        $(".alternate-medicines-container").html(`
                            <div class="alert alert-info">
                                No alternate medicines found for ${medicine.name}.
                            </div>
                        `);
                    } else {
                        let alternatesHtml = `<div class="row">`;

                        alternates.forEach(function (alternate) {
                            alternatesHtml += `
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex mb-2">
                                                <img src="${
                                                    alternate.image
                                                }" alt="${
                                alternate.name
                            }" style="width: 50px; height: 50px; object-fit: cover;" class="me-2">
                                                <div>
                                                    <h6 class="mb-0">${
                                                        alternate.name
                                                    }</h6>
                                                    <small class="text-muted">${
                                                        alternate.generic_name
                                                    }</small>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span>${currency} ${
                                alternate.sale_price
                            }</span>
                                                <span class="badge bg-success">${
                                                    alternate.quantity
                                                } ${
                                alternate.unit?.name || "pcs"
                            }</span>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-primary w-100 add-alternate-to-cart" data-id="${
                                                alternate.id
                                            }">
                                                <i data-feather="shopping-cart" class="feather-14 me-1"></i>Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        alternatesHtml += `</div>`;
                        $(".alternate-medicines-container").html(
                            alternatesHtml
                        );
                        feather.replace();
                    }
                } else {
                    $(".alternate-medicines-container").html(`
                        <div class="alert alert-danger">
                            ${
                                response.message ||
                                "Failed to load alternate medicines."
                            }
                        </div>
                    `);
                }
            },
            error: function () {
                $(".alternate-medicines-container").html(`
                    <div class="alert alert-danger">
                        Failed to load alternate medicines. Please try again.
                    </div>
                `);
            },
        });
    });

    // Delegate click event for adding alternate medicine to cart
    $(document).on("click", ".add-alternate-to-cart", function () {
        const medicineId = $(this).data("id");

        // Check if product is already in cart
        let productExists = false;
        $(".cart-product-item").each(function () {
            if ($(this).data("id") == medicineId) {
                productExists = true;
                return false; // Break the loop
            }
        });

        if (productExists) {
            showPOSNotification(
                "Error!",
                "error",
                "Medicine already in cart. You can update the quantity instead."
            );
            return;
        }

        // Fetch medicine details and add to cart
        $.ajax({
            url: base_url + "/pos/medicine/" + medicineId,
            type: "GET",
            success: function (response) {
                // Add to cart
                addToCart(response);
                // Add to localStorage
                addToLocalStorage(response.id, 1);
                $(".product-wrap .alert").addClass("d-none");
                updateProductCount();

                // Close the modal
                $("#alternate-medicines").modal("hide");

                // Show notification
                showPOSNotification(
                    "Success!",
                    "success",
                    "Alternate medicine added to cart"
                );

                // Update calculations
                calculateSubTotal();
                calculateTotal();
                calculateTax();
                calculateDiscount();
                calculateShipping();

                // Play sound
                cartSound.play();
            },
            error: function () {
                showPOSNotification(
                    "Error!",
                    "error",
                    "Failed to add medicine to cart. Please try again."
                );
            },
        });
    });
});
