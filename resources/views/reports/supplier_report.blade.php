@extends('layouts.app')

@section('title', 'Supplier Report')

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
                <h4>Supplier Report</h4>
                <h6>View purchase activity by supplier</h6>
            </div>
        </div>
    </div>

    <!-- Report filter -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('reports.suppliers') }}" method="GET">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>Supplier</label>
                            <select name="supplier_id" class="select2">
                                <option value="all">All Suppliers</option>
                                @foreach (App\Models\Supplier::all() as $supplier)
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
                            <a href="{{ route('reports.suppliers') }}" class="btn btn-info ms-2">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Supplier List -->
    <div class="card table-list-card">
        <div class="card-body">
            <div class="table-responsive product-list">
                <table class="table datanew list">
                    <thead>
                        <tr>
                            <th>Supplier</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Total Purchases</th>
                            <th>Total Amount</th>
                            <th>Total Paid</th>
                            <th>Total Due</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $supplier)
                            <tr>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->email }}</td>
                                <td>{{ $supplier->phone }}</td>
                                <td>{{ $supplier->purchase_count }}</td>
                                <td>{{ show_amount($supplier->total_purchases, 2) }}</td>
                                <td>{{ show_amount($supplier->total_paid, 2) }}</td>
                                <td>{{ show_amount($supplier->total_due, 2) }}</td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('suppliers.show', $supplier->id) }}">
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
