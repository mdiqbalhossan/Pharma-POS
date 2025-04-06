@extends('layouts.app')

@section('title', 'Sale Details')

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
                <h4>Sale Details</h4>
                <h6>View sale information</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <div class="page-btn">
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                            class="me-2"></i>Back to Sales</a>
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
                        <a href="#" class="btn btn-primary me-2" id="print-sale" onclick="window.print()">
                            <i data-feather="printer" class="me-1"></i> Print
                        </a>
                        <a href="{{ route('sales.download.invoice', $sale->id) }}" class="btn btn-info me-2"
                            id="download-sale">
                            <i data-feather="download" class="me-1"></i> Download
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm border mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Sale Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="sale-info-item">
                                        <span class="text-muted">Reference/Invoice No:</span>
                                        <h6 class="mb-0 mt-1">{{ $sale->sale_no }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="sale-info-item">
                                        <span class="text-muted">Status:</span>
                                        <h6 class="mb-0 mt-1">
                                            <span
                                                class="badge {{ $sale->status == 'success' ? 'bg-success' : 'bg-warning' }}">
                                                {{ ucfirst($sale->status) }}
                                            </span>
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="sale-info-item">
                                        <span class="text-muted">Customer:</span>
                                        <h6 class="mb-0 mt-1">{{ $sale->customer->name }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="sale-info-item">
                                        <span class="text-muted">Sale Date:</span>
                                        <h6 class="mb-0 mt-1">{{ date('d M, Y', strtotime($sale->sale_date)) }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="sale-info-item">
                                        <span class="text-muted">Payment Method:</span>
                                        <h6 class="mb-0 mt-1">{{ $sale->payment_method }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="sale-info-item">
                                        <span class="text-muted">Payment Status:</span>
                                        <h6 class="mb-0 mt-1">
                                            @php
                                                $paymentStatus = 'Paid';
                                                $badgeClass = 'bg-success';

                                                if ($sale->amount_due > 0 && $sale->amount_paid == 0) {
                                                    $paymentStatus = 'Unpaid';
                                                    $badgeClass = 'bg-danger';
                                                } elseif ($sale->amount_due > 0) {
                                                    $paymentStatus = 'Partial';
                                                    $badgeClass = 'bg-warning';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $paymentStatus }}</span>
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="sale-info-item">
                                        <span class="text-muted">Staff:</span>
                                        <h6 class="mb-0 mt-1">{{ $sale->user->name ?? 'N/A' }}</h6>
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
                            <div class="sale-note">
                                {!! $sale->note ?? '<span class="text-muted">No notes available</span>' !!}
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
                            <div class="sale-total">
                                <div class="sale-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">Subtotal:</span>
                                    <span>${{ number_format($sale->total_amount, 2) }}</span>
                                </div>
                                <div class="sale-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">Tax ({{ $sale->tax_percentage }}%):</span>
                                    <span>${{ number_format($sale->tax_amount, 2) }}</span>
                                </div>
                                <div class="sale-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">Discount ({{ $sale->discount_percentage }}%):</span>
                                    <span>${{ number_format($sale->discount_amount, 2) }}</span>
                                </div>
                                <div class="sale-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">Shipping:</span>
                                    <span>${{ number_format($sale->shipping_amount, 2) }}</span>
                                </div>
                                <div
                                    class="sale-total-item d-flex justify-content-between mb-3 border-top border-bottom py-2">
                                    <h5>Grand Total:</h5>
                                    <h5>${{ number_format($sale->grand_total, 2) }}</h5>
                                </div>
                                <div class="sale-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">Paid Amount:</span>
                                    <span>${{ number_format($sale->amount_paid, 2) }}</span>
                                </div>
                                <div class="sale-total-item d-flex justify-content-between mb-3 border-top pt-2">
                                    <h6>Due Amount:</h6>
                                    <h6>${{ number_format($sale->amount_due, 2) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Customer Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="customer-info">
                                <h6>{{ $sale->customer->name }}</h6>
                                @if ($sale->customer->email)
                                    <p class="mb-1"><i data-feather="mail"
                                            class="icon-sm me-2"></i>{{ $sale->customer->email }}</p>
                                @endif
                                @if ($sale->customer->phone)
                                    <p class="mb-1"><i data-feather="phone"
                                            class="icon-sm me-2"></i>{{ $sale->customer->phone }}</p>
                                @endif
                                @if ($sale->customer->address)
                                    <p class="mb-0"><i data-feather="map-pin"
                                            class="icon-sm me-2"></i>{{ $sale->customer->address }}</p>
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
                            <h5 class="mb-0">Sale Items</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Medicine</th>
                                            <th>Qty</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sale->medicines as $index => $medicine)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $medicine->name }}</td>
                                                <td>{{ $medicine->pivot->quantity }}</td>
                                                <td>${{ number_format($medicine->pivot->price, 2) }}</td>
                                                <td>${{ number_format($medicine->pivot->total, 2) }}</td>
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
@endsection

@push('script')
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Toastr JS -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
@endpush
