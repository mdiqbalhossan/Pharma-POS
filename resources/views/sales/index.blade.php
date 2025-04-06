@extends('layouts.app')

@section('title', 'Sales')

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endpush

@section('content')
    <div class="page-header transfer">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Sales List</h4>
                <h6>Manage your sales</h6>
            </div>
        </div>
    </div>

    <!-- /product list -->
    <div class="card table-list-card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-input">
                        <a href="" class="btn btn-searchset"><i data-feather="search" class="feather-search"></i></a>
                    </div>
                </div>
                <div class="search-path">
                    <a class="btn btn-filter" id="filter_search">
                        <i data-feather="filter" class="filter-icon"></i>
                        <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                    </a>
                </div>
                <div class="form-sort">
                    <i data-feather="sliders" class="info-img"></i>
                    <select class="select">
                        <option>Sort by Date</option>
                        <option>Newest</option>
                        <option>Oldest</option>
                    </select>
                </div>
            </div>
            <!-- /Filter -->
            <div class="card" id="filter_inputs">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="input-blocks">
                                <i data-feather="user" class="info-img"></i>
                                <select class="select">
                                    <option>Choose Customer Name</option>
                                    <option value="all">All Customers</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="input-blocks">
                                <i data-feather="stop-circle" class="info-img"></i>
                                <select class="select">
                                    <option>Choose Status</option>
                                    <option>Success</option>
                                    <option>Hold</option>
                                    <option>Cancel</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="input-blocks">
                                <i class="fas fa-money-bill info-img"></i>
                                <select class="select">
                                    <option>Choose Payment Status</option>
                                    <option>Paid</option>
                                    <option>Partial</option>
                                    <option>Unpaid</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 ms-auto">
                            <div class="input-blocks">
                                <a class="btn btn-filters ms-auto"> <i data-feather="search" class="feather-search"></i>
                                    Search </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Filter -->
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
                                <td>{{ number_format($sale->grand_total, 2) }}</td>
                                <td>{{ number_format($sale->amount_paid, 2) }}</td>
                                <td>{{ number_format($sale->amount_due, 2) }}</td>
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
                                        <a class="me-2 p-2" href="{{ route('sales.return', $sale->id) }}">
                                            <i data-feather="refresh-cw" class="action-eye"></i>
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
    <!-- /product list -->
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
