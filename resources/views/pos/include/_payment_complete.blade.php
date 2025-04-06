<div class="modal fade" id="payment-completed" aria-labelledby="payment-completed">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="icon-head mb-4">
                    <i data-feather="check-circle" class="feather-40 text-success"></i>
                </div>
                <h4>Payment Completed</h4>
                <p class="mb-4">Transaction has been completed successfully.</p>
                <div class="d-flex justify-content-between gap-2">
                    <button type="button" class="btn btn-primary flex-fill print-receipt" data-bs-toggle="modal"
                        data-bs-target="#print-receipt" data-id="">
                        <i data-feather="printer" class="feather-16 me-1"></i> Print Receipt
                    </button>
                    <button type="button" class="btn btn-secondary flex-fill" id="new-transaction-btn">
                        <i data-feather="refresh-cw" class="feather-16 me-1"></i> New Transaction
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
