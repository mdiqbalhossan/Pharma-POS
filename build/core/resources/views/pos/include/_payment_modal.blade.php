<!-- Payment Processing Modal -->
<div class="modal fade" id="payment-modal" aria-labelledby="payment-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Process Payment') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="payment-form">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-block">
                                <label>{{ __('Total Amount') }}</label>
                                <input type="text" class="form-control" id="payment-grand-total" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block">
                                <label>{{ __('Amount Received') }}</label>
                                <input type="number" class="form-control" id="payment-amount-received"
                                    placeholder="{{ __('Enter amount') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label>{{ __('Quick Amount') }}</label>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-outline-primary quick-amount"
                                    data-amount="100">100</button>
                                <button type="button" class="btn btn-outline-primary quick-amount"
                                    data-amount="200">200</button>
                                <button type="button" class="btn btn-outline-primary quick-amount"
                                    data-amount="500">500</button>
                                <button type="button" class="btn btn-outline-primary quick-amount"
                                    data-amount="1000">1000</button>
                                <button type="button" class="btn btn-outline-primary quick-amount"
                                    data-amount="2000">2000</button>
                                <button type="button" class="btn btn-outline-primary quick-amount"
                                    data-amount="5000">5000</button>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-success">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>{{ __('Change Due:') }}</span>
                                    <span class="h4 mb-0" id="payment-change-amount">0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-block">
                                <label>{{ __('Note (Optional)') }}</label>
                                <textarea class="form-control" id="payment-note" rows="2"
                                    placeholder="{{ __('Add note about this transaction') }}"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-success" id="complete-sale-btn">
                    <i data-feather="check-circle" class="feather-16 me-1"></i> {{ __('Complete Sale') }}
                </button>
            </div>
        </div>
    </div>
</div>
