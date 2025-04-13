@extends('layouts.app')

@section('title', __('purchase.details'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
@endpush

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>{{ __('purchase.details') }}</h4>
                <h6>{{ __('purchase.view_info') }}</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <div class="page-btn">
                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                            class="me-2"></i>{{ __('purchase.back_to') }}</a>
                </div>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('purchase.collapse') }}"
                    id="collapse-header"><i data-feather="chevron-up" class="feather-chevron-up"></i></a>
            </li>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12 d-flex justify-content-end">
                    <div class="action-buttons">
                        <a class="btn btn-primary me-2" id="print-purchase" data-purchase-id="{{ $purchase->id }}">
                            <i data-feather="printer" class="me-1"></i> {{ __('purchase.action.print') }}
                        </a>
                        <a href="{{ route('purchases.download', $purchase->id) }}" class="btn btn-info me-2"
                            id="download-purchase" data-purchase-id="{{ $purchase->id }}">
                            <i data-feather="download" class="me-1"></i> {{ __('purchase.action.download') }}
                        </a>
                        @if ($purchase->type == 'purchase_order')
                            <a href="#" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#convertPurchaseOrderModal" id="convert-purchase"
                                data-purchase-id="{{ $purchase->id }}">
                                <i data-feather="refresh-cw" class="me-1"></i> {{ __('purchase.convert_to') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm border mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">{{ __('purchase.purchase_info') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="purchase-info-item">
                                        <span class="text-muted">{{ __('purchase.reference_invoice') }}:</span>
                                        <h6 class="mb-0 mt-1">{{ $purchase->invoice_no }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="purchase-info-item">
                                        <span class="text-muted">{{ __('purchase.type') }}:</span>
                                        <h6 class="mb-0 mt-1">
                                            <span
                                                class="badge {{ $purchase->type == 'purchase' ? 'bg-success' : 'bg-warning' }}">
                                                {{ ucfirst(str_replace('_', ' ', $purchase->type)) }}
                                            </span>
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="purchase-info-item">
                                        <span class="text-muted">{{ __('purchase.supplier.title') }}:</span>
                                        <h6 class="mb-0 mt-1">{{ $purchase->supplier->name }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="purchase-info-item">
                                        <span class="text-muted">{{ __('purchase.date') }}:</span>
                                        <h6 class="mb-0 mt-1">{{ date('d M, Y', strtotime($purchase->date)) }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="purchase-info-item">
                                        <span class="text-muted">{{ __('purchase.payment_method') }}:</span>
                                        <h6 class="mb-0 mt-1">{{ $purchase->payment_method }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="purchase-info-item">
                                        <span class="text-muted">{{ __('purchase.payment_status.title') }}:</span>
                                        <h6 class="mb-0 mt-1">
                                            @php
                                                $paymentStatus = 'paid';
                                                $badgeClass = 'bg-success';

                                                if ($purchase->due_amount > 0 && $purchase->paid_amount == 0) {
                                                    $paymentStatus = 'unpaid';
                                                    $badgeClass = 'bg-danger';
                                                } elseif ($purchase->due_amount > 0) {
                                                    $paymentStatus = 'partial';
                                                    $badgeClass = 'bg-warning';
                                                }
                                            @endphp
                                            <span
                                                class="badge {{ $badgeClass }}">{{ __('purchase.payment_status.' . $paymentStatus) }}</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">{{ __('purchase.note') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="purchase-note">
                                {!! $purchase->note ?? '<span class="text-muted">' . __('purchase.no_notes') . '</span>' !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">{{ __('purchase.payment_summary') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="purchase-total">
                                <div class="purchase-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">{{ __('purchase.subtotal') }}:</span>
                                    <span>{{ show_amount($purchase->subtotal) }}</span>
                                </div>
                                <div class="purchase-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">{{ __('purchase.tax') }}:</span>
                                    <span>{{ show_amount($purchase->total_tax) }}</span>
                                </div>
                                <div class="purchase-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">{{ __('purchase.discount') }}:</span>
                                    <span>{{ show_amount($purchase->discount) }}</span>
                                </div>
                                <div class="purchase-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">{{ __('purchase.shipping') }}:</span>
                                    <span>{{ show_amount($purchase->shipping) }}</span>
                                </div>
                                <div
                                    class="purchase-total-item d-flex justify-content-between mb-3 border-top border-bottom py-2">
                                    <h5>{{ __('purchase.grand_total') }}:</h5>
                                    <h5>{{ show_amount($purchase->grand_total) }}</h5>
                                </div>
                                <div class="purchase-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">{{ __('purchase.paid_amount') }}:</span>
                                    <span>{{ show_amount($purchase->paid_amount) }}</span>
                                </div>
                                <div class="purchase-total-item d-flex justify-content-between mb-3 border-top pt-2">
                                    <h6>{{ __('purchase.due_amount') }}:</h6>
                                    <h6>{{ show_amount($purchase->due_amount) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">{{ __('purchase.supplier_info') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="supplier-info">
                                <h6>{{ $purchase->supplier->name }}</h6>
                                @if ($purchase->supplier->email)
                                    <p class="mb-1"><i data-feather="mail"
                                            class="icon-sm me-2"></i>{{ $purchase->supplier->email }}</p>
                                @endif
                                @if ($purchase->supplier->phone)
                                    <p class="mb-1"><i data-feather="phone"
                                            class="icon-sm me-2"></i>{{ $purchase->supplier->phone }}</p>
                                @endif
                                @if ($purchase->supplier->address)
                                    <p class="mb-0"><i data-feather="map-pin"
                                            class="icon-sm me-2"></i>{{ $purchase->supplier->address }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm border mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">{{ __('purchase.medicine') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('purchase.medicine') }}</th>
                                            <th>{{ __('purchase.batch_no') }}</th>
                                            <th>{{ __('purchase.expiry_date') }}</th>
                                            <th>{{ __('purchase.qty') }}</th>
                                            <th>{{ __('purchase.unit_price') }}</th>
                                            <th>{{ __('purchase.discount') }}</th>
                                            <th>{{ __('purchase.tax') }}</th>
                                            <th>{{ __('purchase.subtotal') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchase->medicines as $key => $medicine)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $medicine->name }}</td>
                                                <td>{{ $medicine->pivot->batch_no }}</td>
                                                <td>{{ date('M Y', strtotime($medicine->pivot->expiry_date)) }}</td>
                                                <td>{{ $medicine->pivot->quantity }} {{ $medicine->unit->name }}</td>
                                                <td>{{ show_amount($medicine->pivot->unit_price) }}</td>
                                                <td>{{ show_amount($medicine->pivot->discount_amount) }}</td>
                                                <td>{{ show_amount($medicine->pivot->tax_amount) }}</td>
                                                <td>{{ show_amount($medicine->pivot->subtotal) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Convert Purchase Order Modal -->
    <div class="modal fade" id="convertPurchaseOrderModal" tabindex="-1"
        aria-labelledby="convertPurchaseOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="convertPurchaseOrderModalLabel">
                        {{ __('purchase.convert_order_purchase') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content will be dynamically loaded via AJAX -->
                    <p>{{ __('purchase.loading_details') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('purchase.action.cancel') }}</button>
                    <button type="button" class="btn btn-primary"
                        id="convertPurchaseOrderBtn">{{ __('purchase.convert') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Toastr JS -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <!-- Purchase JS -->
    <script src="{{ asset('assets/js/pages/purchase_show.js') }}"></script>
@endpush
