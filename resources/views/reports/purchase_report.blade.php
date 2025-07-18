@extends('layouts.app')

@section('title', __('index.Purchase Report'))

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
                <h4>{{ __('index.Purchase Report') }}</h4>
                <h6>{{ __('index.View and analyze your purchases') }}</h6>
            </div>
        </div>
    </div>

    <!-- Report filter -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('reports.purchases') }}" method="GET">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('index.Supplier') }}</label>
                            <select name="supplier_id" class="select2">
                                <option value="">{{ __('index.All Suppliers') }}</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('index.Status') }}</label>
                            <select name="status" class="select2">
                                <option value="">{{ __('index.All Status') }}</option>
                                <option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>
                                    {{ __('index.Received') }}</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                    {{ __('index.Pending') }}</option>
                                <option value="ordered" {{ request('status') == 'ordered' ? 'selected' : '' }}>
                                    {{ __('index.Ordered') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('index.Payment Status') }}</label>
                            <select name="payment_status" class="select2">
                                <option value="">{{ __('index.All Payment Status') }}</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>
                                    {{ __('index.Paid') }}
                                </option>
                                <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>
                                    {{ __('index.Partial') }}</option>
                                <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>
                                    {{ __('index.Unpaid') }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('index.From Date') }}</label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" name="start_date" class="datetimepicker"
                                    placeholder="{{ __('index.Choose Date') }}" value="{{ request('start_date') ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('index.To Date') }}</label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" name="end_date" class="datetimepicker"
                                    placeholder="{{ __('index.Choose Date') }}" value="{{ request('end_date') ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary">{{ __('index.Search') }}</button>
                            <a href="{{ route('reports.purchases') }}"
                                class="btn btn-info ms-2">{{ __('index.Reset') }}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Purchase Summary -->
    <div class="row">
        <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($totalPurchases, 2) }}</h4>
                    <h5>{{ __('index.Total Purchase Amount') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($totalPaid, 2) }}</h4>
                    <h5>{{ __('index.Amount Paid') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($totalDue, 2) }}</h4>
                    <h5>{{ __('index.Due') }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Purchase List -->
    <div class="card table-list-card">
        <div class="card-body">
            <div class="table-responsive product-list">
                <table class="table datanew list">
                    <thead>
                        <tr>
                            <th>{{ __('index.Purchase No') }}</th>
                            <th>{{ __('index.Supplier') }}</th>
                            <th>{{ __('index.Date') }}</th>
                            <th>{{ __('index.Grand Total') }}</th>
                            <th>{{ __('index.Paid') }}</th>
                            <th>{{ __('index.Due') }}</th>
                            <th>{{ __('index.Payment Status') }}</th>
                            <th class="no-sort">{{ __('index.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchases as $purchase)
                            <tr>
                                <td>#{{ $purchase->invoice_no }}</td>
                                <td>{{ $purchase->supplier ? $purchase->supplier->name : __('index.N/A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</td>
                                <td>{{ show_amount($purchase->grand_total, 2) }}</td>
                                <td>{{ show_amount($purchase->amount_paid, 2) }}</td>
                                <td>{{ show_amount($purchase->amount_due, 2) }}</td>
                                <td>
                                    @if ($purchase->amount_due <= 0)
                                        <span class="badge-linesuccess">{{ __('index.Paid') }}</span>
                                    @elseif($purchase->amount_paid > 0 && $purchase->amount_due > 0)
                                        <span class="badges-warning">{{ __('index.Partial') }}</span>
                                    @else
                                        <span class="badge badge-linedangered">{{ __('index.Unpaid') }}</span>
                                    @endif
                                </td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('purchases.show', $purchase->id) }}">
                                            <i data-feather="eye" class="action-eye"></i>
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
