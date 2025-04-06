<div class="modal fade modal-default pos-modal" id="products" aria-labelledby="products">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <h5 class="me-4">Products</h5>
                    <span class="badge bg-info d-inline-block mb-0">Order ID: <span id="product-order-id"></span></span>
                </div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="product-wrap" id="order-products-container">
                    <!-- Products will be loaded here dynamically -->
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p>Loading products...</p>
                    </div>
                </div>
                <div class="modal-footer d-sm-flex justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
