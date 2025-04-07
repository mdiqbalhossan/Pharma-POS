@extends('layouts.app')

@section('title', __('Invoice Report'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endpush

@section('content')
    <div class="page-header report">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>{{ __('Invoice Report') }}</h4>
                <h6>{{ __('Track invoice status and payments') }}</h6>
            </div>
        </div>
    </div>

    <!-- Report filter -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('reports.invoice') }}" method="GET">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('Customer') }}</label>
                            <select name="customer_id" class="select2">
                                <option value="">{{ __('All Customers') }}</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('Invoice No') }}</label>
                            <input type="text" name="invoice_no" value="{{ request('invoice_no') ?? '' }}"
                                placeholder="{{ __('Enter invoice number') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('From Date') }}</label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" name="start_date" class="datetimepicker"
                                    placeholder="{{ __('Choose Date') }}" value="{{ request('start_date') ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('To Date') }}</label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" name="end_date" class="datetimepicker"
                                    placeholder="{{ __('Choose Date') }}" value="{{ request('end_date') ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                            <a href="{{ route('reports.invoice') }}" class="btn btn-info ms-2">{{ __('Reset') }}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Invoice List -->
    <div class="card table-list-card">
        <div class="card-body">
            <div class="table-responsive product-list">
                <table class="table datanew list">
                    <thead>
                        <tr>
                            <th>{{ __('Invoice No') }}</th>
                            <th>{{ __('Customer') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Items') }}</th>
                            <th>{{ __('Sub Total') }}</th>
                            <th>{{ __('Tax') }}</th>
                            <th>{{ __('Discount') }}</th>
                            <th>{{ __('Grand Total') }}</th>
                            <th>{{ __('Payment Status') }}</th>
                            <th class="no-sort">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>#{{ $invoice->sale_no }}</td>
                                <td>{{ $invoice->customer ? $invoice->customer->name : __('N/A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->sale_date)->format('d M Y') }}</td>
                                <td>{{ $invoice->medicines->count() }}</td>
                                <td>{{ show_amount($invoice->total_amount, 2) }}</td>
                                <td>{{ show_amount($invoice->tax_amount, 2) }}</td>
                                <td>{{ show_amount($invoice->discount_amount, 2) }}</td>
                                <td>{{ show_amount($invoice->grand_total, 2) }}</td>
                                <td>
                                    @if ($invoice->amount_due <= 0)
                                        <span class="badge-linesuccess">{{ __('Paid') }}</span>
                                    @elseif($invoice->amount_paid > 0 && $invoice->amount_due > 0)
                                        <span class="badges-warning">{{ __('Partial') }}</span>
                                    @else
                                        <span class="badge badge-linedangered">{{ __('Unpaid') }}</span>
                                    @endif
                                </td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('sales.show', $invoice->id) }}">
                                            <i data-feather="eye" class="action-eye"></i>
                                        </a>
                                        <a class="me-2 p-2" href="{{ route('sales.invoice', $invoice->id) }}">
                                            <i data-feather="file-text" class="action-eye"></i>
                                        </a>
                                        <a class="me-2 p-2" href="{{ route('sales.download.invoice', $invoice->id) }}">
                                            <i data-feather="download" class="action-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
    <!-- Datetimepicker JS -->
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
@endpush
