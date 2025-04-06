@extends('layouts.app')

@section('title', 'Sales Report')

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
                <h4>Sales Report</h4>
                <h6>View and analyze your sales data</h6>
            </div>
        </div>
    </div>

    <!-- Report filter -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('reports.sales') }}" method="GET">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>Customer</label>
                            <select name="customer_id" class="select2">
                                <option value="all">All Customers</option>
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
                            <label>Status</label>
                            <select name="status" class="select2">
                                <option value="">All Status</option>
                                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success
                                </option>
                                <option value="hold" {{ request('status') == 'hold' ? 'selected' : '' }}>Hold</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>Payment Status</label>
                            <select name="payment_status" class="select2">
                                <option value="">All Payment Status</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid
                                </option>
                                <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>
                                    Partial</option>
                                <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>From Date</label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" name="start_date" class="datetimepicker" placeholder="Choose Date"
                                    value="{{ request('start_date') ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>To Date</label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" name="end_date" class="datetimepicker" placeholder="Choose Date"
                                    value="{{ request('end_date') ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('reports.sales') }}" class="btn btn-info ms-2">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Sales Summary -->
    <div class="row">
        <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($totalSales, 2) }}</h4>
                    <h5>Total Sales Amount</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($totalPaid, 2) }}</h4>
                    <h5>Total Paid Amount</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($totalDue, 2) }}</h4>
                    <h5>Total Due Amount</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales List -->
    <div class="card table-list-card">
        <div class="card-body">
            <div class="table-responsive product-list">
                <table class="table datanew list">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Reference</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Grand Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Payment Status</th>
                            <th class="no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                            <tr>
                                <td>{{ $sale->customer ? $sale->customer->name : 'N/A' }}</td>
                                <td>#{{ $sale->sale_no }}</td>
                                <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }}</td>
                                <td>
                                    @if ($sale->status == 'success')
                                        <span class="badges status-badge">Success</span>
                                    @elseif($sale->status == 'hold')
                                        <span class="badges status-badge ordered">Hold</span>
                                    @endif
                                </td>
                                <td>{{ show_amount($sale->grand_total, 2) }}</td>
                                <td>{{ show_amount($sale->amount_paid, 2) }}</td>
                                <td>{{ show_amount($sale->amount_due, 2) }}</td>
                                <td>
                                    @if ($sale->amount_due <= 0)
                                        <span class="badge-linesuccess">Paid</span>
                                    @elseif($sale->amount_paid > 0 && $sale->amount_due > 0)
                                        <span class="badges-warning">Partial</span>
                                    @else
                                        <span class="badge badge-linedangered">Unpaid</span>
                                    @endif
                                </td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('sales.show', $sale->id) }}">
                                            <i data-feather="eye" class="action-eye"></i>
                                        </a>
                                        <a class="me-2 p-2" href="{{ route('sales.invoice', $sale->id) }}">
                                            <i data-feather="file-text" class="action-eye"></i>
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
