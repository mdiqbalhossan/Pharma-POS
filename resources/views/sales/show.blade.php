@extends('layouts.app')

@section('title', __('index.Sale Details'))

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
                <h4>{{ __('index.Sale Details') }}</h4>
                <h6>{{ __('index.View and analyze your sales data') }}</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <div class="page-btn">
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                            class="me-2"></i>{{ __('index.Back') }}</a>
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
                        <a href="#" class="btn btn-primary me-2" id="print-sale" data-sale-id="{{ $sale->id }}">
                            <i data-feather="printer" class="me-1"></i> {{ __('index.Print Receipt') }}
                        </a>
                        <a href="{{ route('sales.download.invoice', $sale->id) }}" class="btn btn-info me-2"
                            id="download-sale">
                            <i data-feather="download" class="me-1"></i> {{ __('index.Download') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm border mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">{{ __('index.Sale Information') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="sale-info-item">
                                        <span class="text-muted">{{ __('index.Reference/Invoice No:') }}</span>
                                        <h6 class="mb-0 mt-1">{{ $sale->sale_no }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="sale-info-item">
                                        <span class="text-muted">{{ __('index.Status') }}:</span>
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
                                        <span class="text-muted">{{ __('index.Customer') }}:</span>
                                        <h6 class="mb-0 mt-1">{{ $sale->customer->name }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="sale-info-item">
                                        <span class="text-muted">{{ __('index.Sale Date:') }}</span>
                                        <h6 class="mb-0 mt-1">{{ date('d M, Y', strtotime($sale->sale_date)) }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="sale-info-item">
                                        <span class="text-muted">{{ __('index.Payment Method') }}:</span>
                                        <h6 class="mb-0 mt-1">{{ $sale->payment_method }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="sale-info-item">
                                        <span class="text-muted">{{ __('index.Payment Status') }}:</span>
                                        <h6 class="mb-0 mt-1">
                                            @php
                                                $paymentStatus = __('index.Paid');
                                                $badgeClass = 'bg-success';

                                                if ($sale->amount_due > 0 && $sale->amount_paid == 0) {
                                                    $paymentStatus = __('index.Unpaid');
                                                    $badgeClass = 'bg-danger';
                                                } elseif ($sale->amount_due > 0) {
                                                    $paymentStatus = __('index.Partial');
                                                    $badgeClass = 'bg-warning';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $paymentStatus }}</span>
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="sale-info-item">
                                        <span class="text-muted">{{ __('index.Staff') }}:</span>
                                        <h6 class="mb-0 mt-1">{{ $sale->user->name ?? __('index.N/A') }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">{{ __('index.Note') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="sale-note">
                                {!! $sale->note ?? '<span class="text-muted">' . __('index.No notes available') . '</span>' !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">{{ __('index.Payment Summary') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="sale-total">
                                <div class="sale-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">{{ __('index.Sub Total') }}:</span>
                                    <span>{{ show_amount($sale->total_amount) }}</span>
                                </div>
                                <div class="sale-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">{{ __('index.Tax') }} ({{ $sale->tax_percentage }}%):</span>
                                    <span>{{ show_amount($sale->tax_amount) }}</span>
                                </div>
                                <div class="sale-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">{{ __('index.Discount') }}
                                        ({{ $sale->discount_percentage }}%):</span>
                                    <span>{{ show_amount($sale->discount_amount) }}</span>
                                </div>
                                <div class="sale-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">{{ __('index.Shipping') }}:</span>
                                    <span>{{ show_amount($sale->shipping_amount) }}</span>
                                </div>
                                <div
                                    class="sale-total-item d-flex justify-content-between mb-3 border-top border-bottom py-2">
                                    <h5>{{ __('index.Grand Total') }}:</h5>
                                    <h5>{{ show_amount($sale->grand_total) }}</h5>
                                </div>
                                <div class="sale-total-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">{{ __('index.Amount Paid') }}:</span>
                                    <span>{{ show_amount($sale->amount_paid) }}</span>
                                </div>
                                <div class="sale-total-item d-flex justify-content-between mb-3 border-top pt-2">
                                    <h6>{{ __('index.Due') }}:</h6>
                                    <h6>{{ show_amount($sale->amount_due) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">{{ __('index.Customer Information') }}</h5>
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
                            <h5 class="mb-0">{{ __('index.Sale Items') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('index.Medicine') }}</th>
                                            <th>{{ __('index.Qty') }}</th>
                                            <th>{{ __('index.Unit Price') }}</th>
                                            <th>{{ __('index.Total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sale->medicines as $index => $medicine)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $medicine->name }}</td>
                                                <td>{{ $medicine->pivot->quantity }} {{ $medicine->unit->name }}</td>
                                                <td>{{ show_amount($medicine->pivot->price) }}</td>
                                                <td>{{ show_amount($medicine->pivot->total) }}</td>
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

    <script src="{{ asset('assets/js/pages/sale_show.js') }}"></script>
@endpush
