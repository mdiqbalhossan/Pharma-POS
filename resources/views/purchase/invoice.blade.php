@extends('layouts.app')

@section('title', __('purchase.invoice_title'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #invoice-container,
            #invoice-container * {
                visibility: visible;
            }

            #invoice-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            /* Ensure layout is preserved during print */
            .row {
                display: flex !important;
            }

            .col-md-6 {
                width: 50% !important;
                float: left !important;
            }

            /* Remove unnecessary margins/paddings for better print layout */
            #invoice-container .card {
                border: none !important;
                box-shadow: none !important;
            }

            /* Clean print layout */
            @page {
                margin: 0.5cm;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>{{ __('purchase.invoice_title') }} #{{ $purchase->invoice_no }}</h4>
                <h6>{{ __('purchase.view_invoice_details') }}</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <div class="page-btn">
                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                            class="me-2"></i>{{ __('purchase.back_to_purchase') }}</a>
                </div>
            </li>
        </ul>
    </div>

    <div id="invoice-container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-sm border mb-4">
                    <div class="card-body invoice-content">
                        <!-- Invoice Header -->
                        <div class="invoice-header mb-4 pb-3 border-bottom">
                            <div class="row">
                                <div class="col-md-6">
                                    @if (setting('logo'))
                                        <div class="logo-container mb-3">
                                            <img src="{{ asset('storage/' . setting('logo')) }}"
                                                alt="{{ __('purchase.company_logo') }}" class="img-fluid"
                                                style="max-height: 80px;">
                                        </div>
                                    @endif
                                    <h2 class="company-name">{{ setting('company_name') }}</h2>
                                    <div class="company-details">
                                        @if (setting('company_address'))
                                            <p class="company-address mb-1">{{ setting('company_address') }}</p>
                                        @endif
                                        @if (setting('company_phone'))
                                            <p class="company-phone mb-1">{{ __('purchase.phone') }}:
                                                {{ setting('company_phone') }}</p>
                                        @endif
                                        @if (setting('company_email'))
                                            <p class="company-email mb-0">{{ __('purchase.email') }}:
                                                {{ setting('company_email') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h1 class="invoice-title">{{ __('purchase.purchase_invoice') }}</h1>
                                    <div class="invoice-details mt-3">
                                        <p class="invoice-id mb-1">{{ __('purchase.invoice_no') }}:
                                            #{{ $purchase->invoice_no }}
                                        </p>
                                        <p class="invoice-date mb-1">{{ __('purchase.date') }}:
                                            {{ date('d M, Y', strtotime($purchase->date)) }}</p>
                                        <p class="payment-status mb-0">
                                            {{ __('purchase.status') }}:
                                            @php
                                                $statusText = 'Paid';
                                                $statusClass = 'text-success';

                                                if ($purchase->due_amount > 0 && $purchase->paid_amount == 0) {
                                                    $statusText = 'Unpaid';
                                                    $statusClass = 'text-danger';
                                                } elseif ($purchase->due_amount > 0) {
                                                    $statusText = 'Partial';
                                                    $statusClass = 'text-warning';
                                                }
                                            @endphp
                                            <span class="{{ $statusClass }}">{{ $statusText }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Supplier and Purchase Information -->
                        <div class="invoice-info mb-4 pb-3 border-bottom">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="section-title">{{ __('purchase.supplier_info') }}</h5>
                                    <div class="supplier-details">
                                        <p class="supplier-name mb-1">{{ $purchase->supplier->name }}</p>
                                        @if ($purchase->supplier->email)
                                            <p class="supplier-email mb-1">{{ __('purchase.email') }}:
                                                {{ $purchase->supplier->email }}</p>
                                        @endif
                                        @if ($purchase->supplier->phone)
                                            <p class="supplier-phone mb-1">{{ __('purchase.phone') }}:
                                                {{ $purchase->supplier->phone }}</p>
                                        @endif
                                        @if ($purchase->supplier->address)
                                            <p class="supplier-address mb-0">{{ __('purchase.address') }}:
                                                {{ $purchase->supplier->address }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="section-title">{{ __('purchase.purchase_info') }}</h5>
                                    <div class="purchase-details">
                                        <p class="purchase-type mb-1">{{ __('purchase.purchase_type') }}:
                                            {{ ucfirst(str_replace('_', ' ', $purchase->type)) }}</p>
                                        @if ($purchase->reference_no)
                                            <p class="purchase-ref mb-1">{{ __('purchase.reference') }}:
                                                {{ $purchase->reference_no }}</p>
                                        @endif
                                        <p class="payment-method mb-0">{{ __('purchase.payment_method') }}:
                                            {{ $purchase->payment_method }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Purchase Items Table -->
                        <div class="invoice-items mb-4">
                            <h5 class="section-title mb-3">{{ __('purchase.purchase_items') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('purchase.item') }}</th>
                                            <th>{{ __('purchase.batch') }}</th>
                                            <th>{{ __('purchase.expiry') }}</th>
                                            <th>{{ __('purchase.qty') }}</th>
                                            <th>{{ __('purchase.unit_price') }}</th>
                                            <th>{{ __('purchase.discount') }}</th>
                                            <th>{{ __('purchase.tax') }}</th>
                                            <th>{{ __('purchase.total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchase->medicines as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->medicine ? $item->medicine->name : 'N/A' }}</td>
                                                <td>{{ $item->batch_no }}</td>
                                                <td>{{ $item->expiry_date ? date('M Y', strtotime($item->expiry_date)) : 'N/A' }}
                                                </td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>${{ number_format($item->unit_price, 2) }}</td>
                                                <td>${{ number_format($item->discount_amount, 2) }}</td>
                                                <td>${{ number_format($item->tax_amount, 2) }}</td>
                                                <td>${{ number_format($item->subtotal, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Payment Summary -->
                        <div class="invoice-summary mb-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="notes">
                                        <h5 class="section-title mb-3">{{ __('purchase.notes') }}</h5>
                                        <div class="note-content p-3 bg-light rounded">
                                            {!! $purchase->note ?? '<em>' . __('purchase.no_notes') . '</em>' !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="payment-summary">
                                        <h5 class="section-title mb-3">{{ __('purchase.summary') }}</h5>
                                        <div class="summary-table">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td>{{ __('purchase.subtotal') }}</td>
                                                        <td class="text-end">${{ number_format($purchase->subtotal, 2) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('purchase.tax') }}</td>
                                                        <td class="text-end">
                                                            ${{ number_format($purchase->total_tax, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('purchase.discount') }}</td>
                                                        <td class="text-end">
                                                            ${{ number_format($purchase->discount, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('purchase.shipping') }}</td>
                                                        <td class="text-end">
                                                            ${{ number_format($purchase->shipping, 2) }}</td>
                                                    </tr>
                                                    <tr class="fw-bold">
                                                        <td>{{ __('purchase.grand_total') }}</td>
                                                        <td class="text-end">
                                                            ${{ number_format($purchase->grand_total, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('purchase.paid_amount') }}</td>
                                                        <td class="text-end">
                                                            ${{ number_format($purchase->paid_amount, 2) }}</td>
                                                    </tr>
                                                    <tr class="fw-bold">
                                                        <td>{{ __('purchase.due_amount') }}</td>
                                                        <td class="text-end">
                                                            ${{ number_format($purchase->due_amount, 2) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="invoice-footer mt-5 pt-4 border-top">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="terms-conditions">
                                        <h6>{{ __('purchase.terms_conditions') }}</h6>
                                        <p class="small">
                                            {{ setting('invoice_terms') ?? __('purchase.standard_terms') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="invoice-signature">
                                        <p>{{ __('purchase.authorized_signature') }}</p>
                                        <div class="signature-line mt-4">____________________</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 text-center">
                                    <p class="small mb-0">{{ __('purchase.thank_you') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            window.print();
        });
    </script>
@endpush
