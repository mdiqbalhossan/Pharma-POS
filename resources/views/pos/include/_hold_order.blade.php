<div class="modal fade modal-default pos-modal" id="hold-order" aria-labelledby="hold-order">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-4">
                <h5>Hold order</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form id="hold-order-form">
                    <h2 class="text-center p-4" id="hold-total">4500.00</h2>
                    <div class="input-block">
                        <label>Order Reference</label>
                        <input class="form-control" type="text" value="" placeholder="Order Reference"
                            id="hold-reference">
                    </div>
                    <p>The current order will be set on hold. You can retreive this order from the pending order button.
                        Providing a reference to it might help you to identify the order more quickly.</p>
                    <div class="modal-footer d-sm-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
