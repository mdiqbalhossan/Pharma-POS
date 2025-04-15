<div class="modal fade" id="low-stock-modal">
    <div class="modal-dialog modal-dialog-centered custom-modal-two modal-lg">
        <div class="modal-content">
            <div class="page-wrapper-new p-0">
                <div class="content">
                    <div class="modal-header border-0 custom-modal-header">
                        <div class="page-title">
                            <h4>{{ __('modal.low_stock_modal.title') }}</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body custom-modal-body">

                        <div class="alert alert-outline-info alert-dismissible fade show">
                            {{ __('modal.low_stock_modal.alert_message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                                    class="fas fa-xmark"></i></button>
                        </div>

                        <ul class="nav nav-pills modal-table-tab" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-low-stock-product-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-low-stock-product" type="button" role="tab"
                                    aria-controls="pills-low-stock-product"
                                    aria-selected="true">{{ __('modal.low_stock_modal.low_stock_tab') }}
                                    ({{ low_stock_product()->count() }})</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-upcoming-expired-product-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-upcoming-expired-product" type="button" role="tab"
                                    aria-controls="pills-upcoming-expired-product"
                                    aria-selected="false">{{ __('modal.low_stock_modal.upcoming_expired_tab') }}
                                    ({{ near_expired_product()->count() }})</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-low-stock-product" role="tabpanel"
                                aria-labelledby="pills-low-stock-product-tab">

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('modal.low_stock_modal.name') }}</th>
                                            <th>{{ __('modal.low_stock_modal.quantity') }}</th>
                                            <th>{{ __('modal.low_stock_modal.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (low_stock_product() as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="p-2 me-2"
                                                            href="{{ route('medicines.show', $product->id) }}"
                                                            data-bs-toggle="tooltip" title="{{ __('medicine.view') }}">
                                                            <i data-feather="eye" class="feather-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                            <div class="tab-pane fade" id="pills-upcoming-expired-product" role="tabpanel"
                                aria-labelledby="pills-upcoming-expired-product-tab">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('modal.low_stock_modal.name') }}</th>
                                            <th>{{ __('modal.low_stock_modal.expiry_date') }}</th>
                                            <th>{{ __('modal.low_stock_modal.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (near_expired_product() as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ Carbon\Carbon::parse($product->expiration_date)->format('d M Y') }}
                                                </td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="p-2 me-2"
                                                            href="{{ route('medicines.show', $product->id) }}"
                                                            data-bs-toggle="tooltip" title="{{ __('medicine.view') }}">
                                                            <i data-feather="eye" class="feather-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="modal-footer-btn">
                            <button type="button" class="btn btn-cancel me-2"
                                data-bs-dismiss="modal">{{ __('modal.low_stock_modal.cancel') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Add Shift -->
