<div class="modal fade" id="alternate-medicines" tabindex="-1" aria-labelledby="alternateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alternateModalLabel">{{ __('index.Alternate Medicines') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6>{{ __('index.Original Medicine') }}:</h6>
                        <div class="selected-medicine mb-3"></div>
                    </div>
                    <h6>{{ __('index.Available Alternatives') }}:</h6>
                    <div class="alternate-medicines-container">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">{{ __('index.Loading...') }}</span>
                            </div>
                            <p class="mt-2">{{ __('index.Loading alternate medicines...') }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('index.Close') }}</button>
                </div>
            </div>
        </div>
    </div>