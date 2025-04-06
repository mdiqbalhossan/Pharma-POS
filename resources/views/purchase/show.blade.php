@extends('layouts.app')

@section('title', 'Purchase Details')

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
                <h4>Purchase Details</h4>
                <h6>View purchase information</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <div class="page-btn">
                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                            class="me-2"></i>Back to Purchase</a>
                </div>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                        data-feather="chevron-up" class="feather-chevron-up"></i></a>
            </li>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12 d-flex justify-content-end">
                    <div class="action-buttons">
                        <a href="#" class="btn btn-primary me-2" id="print-purchase"
                            data-purchase-id="{{ $purchase->id }}">
                            <i data-feather="printer" class="me-1"></i> Print
                        </a>
                        <a href="#" class="btn btn-info me-2" id="download-purchase"
                            data-purchase-id="{{ $purchase->id }}">
                            <i data-feather="download" class="me-1"></i> Download
                        </a>
                        @if ($purchase->type == 'purchase_order')
                            <a href="#" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#convertPurchaseOrderModal" id="convert-purchase"
                                data-purchase-id="{{ $purchase->id }}">
                                <i data-feather="refresh-cw" class="me-1"></i> Convert to Purchase
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm border mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Purchase Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="purchase-info-item">
                                        <span class="text-muted">Reference/Invoice No:</span>
                                        <h6 class="mb-0 mt-1">{{ $purchase->invoice_no }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="purchase-info-item">
                                        <span class="text-muted">Purchase Type:</span>
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
                                        <span class="text-muted">Supplier:</span>
                                        <h6 class="mb-0 mt-1">{{ $purchase->supplier->name }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="purchase-info-item">
                                        <span class="text-muted">Purchase Date:</span>
                                        <h6 class="mb-0 mt-1">{{ date('d M, Y', strtotime($purchase->date)) }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="purchase-info-item">
                                        <span class="text-muted">Payment Method:</span>
                                        <h6 class="mb-0 mt-1">{{ $purchase->payment_method }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="purchase-info-item">
                                        <span class="text-muted">Payment Status:</span>
                                        <h6 class="mb-0 mt-1">
                                            @php
                                                $paymentStatus = 'Paid';
                                                $badgeClass = 'bg-success';

                                                if ($purchase->due_amount > 0 && $purchase->paid_amount == 0) {
                                                    $paymentStatus = 'Unpaid';
                                                    $badgeClass = 'bg-danger';
                                                } elseif ($purchase->due_amount > 0) {
                                                    $paymentStatus = 'Partial';
                                                    $badgeClass = 'bg-warning';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $paymentStatus }}</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Note</h5>
                        </div>
                        <div class="card-body">
                            <div class="purchase-note">
                                {!! $purchase->note ?? '<span class="text-muted">No notes available</span>' !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Payment Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="purchase-total">
                                <div class="purchase-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">Subtotal:</span>
                                    <span>${{ number_format($purchase->subtotal, 2) }}</span>
                                </div>
                                <div class="purchase-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">Tax:</span>
                                    <span>${{ number_format($purchase->total_tax, 2) }}</span>
                                </div>
                                <div class="purchase-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">Discount:</span>
                                    <span>${{ number_format($purchase->discount, 2) }}</span>
                                </div>
                                <div class="purchase-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">Shipping:</span>
                                    <span>${{ number_format($purchase->shipping, 2) }}</span>
                                </div>
                                <div
                                    class="purchase-total-item d-flex justify-content-between mb-3 border-top border-bottom py-2">
                                    <h5>Grand Total:</h5>
                                    <h5>${{ number_format($purchase->grand_total, 2) }}</h5>
                                </div>
                                <div class="purchase-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">Paid Amount:</span>
                                    <span>${{ number_format($purchase->paid_amount, 2) }}</span>
                                </div>
                                <div class="purchase-total-item d-flex justify-content-between mb-3 border-top pt-2">
                                    <h6>Due Amount:</h6>
                                    <h6>${{ number_format($purchase->due_amount, 2) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Supplier Information</h5>
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
                            <h5 class="mb-0">Purchase Items</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Medicine</th>
                                            <th>Batch No</th>
                                            <th>Expiry Date</th>
                                            <th>Qty</th>
                                            <th>Unit Price</th>
                                            <th>Discount</th>
                                            <th>Tax</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchase->medicines as $index => $medicine)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $medicine->name }}</td>
                                                <td>{{ $medicine->pivot->batch_no }}</td>
                                                <td>{{ date('d M, Y', strtotime($medicine->pivot->expiry_date)) }}</td>
                                                <td>{{ $medicine->pivot->quantity }}</td>
                                                <td>${{ number_format($medicine->pivot->unit_price, 2) }}</td>
                                                <td>${{ number_format($medicine->pivot->discount, 2) }}</td>
                                                <td>${{ number_format($medicine->pivot->total_tax, 2) }}</td>
                                                <td>${{ number_format($medicine->pivot->grand_total, 2) }}</td>
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

    {{-- Convert Purchase Order to Purchase --}}
    <div class="modal fade" id="convertPurchaseOrderModal" tabindex="-1"
        aria-labelledby="convertPurchaseOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="convertPurchaseOrderModalLabel">Convert Purchase Order to Purchase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content will be dynamically loaded via AJAX -->
                    <p>Loading purchase details...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="convertPurchaseOrderBtn">Convert</button>
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

    <!-- Convert Purchase Order to Purchase -->
    <script src="{{ asset('assets/js/pages/purchase_details.js') }}"></script>
@endpush
