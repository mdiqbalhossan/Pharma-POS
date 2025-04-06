@extends('layouts.app')

@section('title', 'Sale Returns')

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
                <h4>Sale Return List</h4>
                <h6>Manage your sale returns</h6>
            </div>
        </div>
    </div>

    <!-- Sale Return list -->
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

            <!-- Filter -->
            <div class="card" id="filter_inputs">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="input-blocks">
                                <i data-feather="user" class="info-img"></i>
                                <select class="select">
                                    <option>Choose Customer Name</option>
                                    <option>John Doe</option>
                                    <option>Jane Smith</option>
                                    <option>Michael Johnson</option>
                                    <option>Sarah Williams</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="input-blocks">
                                <i data-feather="file" class="info-img"></i>
                                <select class="select">
                                    <option>Enter Reference</option>
                                    <option>SR001</option>
                                    <option>SR002</option>
                                    <option>SR003</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-12">
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
                            <th>Sale Invoice</th>
                            <th>Medicine</th>
                            <th>Date</th>
                            <th>Returned Quantity</th>
                            <th>Unit Price</th>
                            <th>Grand Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Payment Status</th>
                            <th class="no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saleReturns as $return)
                            <tr>
                                <td>#{{ $return->sale ? $return->sale->sale_no : 'N/A' }}</td>
                                <td>{{ $return->medicine ? $return->medicine->name : 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($return->created_at)->format('d M Y') }}</td>
                                <td>{{ $return->quantity }}</td>
                                <td>{{ number_format($return->unit_price, 2) }}</td>
                                <td>{{ number_format($return->grand_total, 2) }}</td>
                                <td>{{ number_format($return->paid_amount, 2) }}</td>
                                <td>{{ number_format($return->due_amount, 2) }}</td>
                                <td>
                                    @if ($return->due_amount <= 0)
                                        <span class="badge-linesuccess">Paid</span>
                                    @elseif($return->paid_amount > 0 && $return->due_amount > 0)
                                        <span class="badges-warning">Partial</span>
                                    @else
                                        <span class="badge badge-linedangered">Unpaid</span>
                                    @endif
                                </td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('sale-returns.show', $return->id) }}">
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
    <!-- /Sale Return list -->
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
