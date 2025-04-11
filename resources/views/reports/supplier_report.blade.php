@extends('layouts.app')

@section('title', __('reports.supplier_report'))

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
                <h4>{{ __('reports.supplier_report') }}</h4>
                <h6>{{ __('reports.view_supplier_purchase_history') }}</h6>
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
                            <label>{{ __('reports.supplier') }}</label>
                            <select name="supplier_id" class="select2">
                                <option value="">{{ __('reports.all_suppliers') }}</option>
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
                            <label>{{ __('reports.from_date') }}</label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" name="start_date" class="datetimepicker"
                                    placeholder="{{ __('Choose Date') }}" value="{{ request('start_date') ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('reports.to_date') }}</label>
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
                            <button type="submit" class="btn btn-primary">{{ __('reports.search') }}</button>
                            <a href="{{ route('reports.suppliers') }}"
                                class="btn btn-info ms-2">{{ __('reports.reset') }}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Supplier Summary -->
    <div class="row">
        <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ $totalPurchases }}</h4>
                    <h5>{{ __('reports.total_purchases') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($totalAmount, 2) }}</h4>
                    <h5>{{ __('reports.total_purchase_amount') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($totalPaid, 2) }}</h4>
                    <h5>{{ __('reports.amount_paid') }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Supplier List -->
    <div class="card table-list-card">
        <div class="card-body">
            <div class="table-responsive product-list">
                <table class="table datanew list">
                    <thead>
                        <tr>
                            <th>{{ __('reports.supplier') }}</th>
                            <th>{{ __('reports.email') }}</th>
                            <th>{{ __('reports.phone') }}</th>
                            <th>{{ __('reports.total_purchases') }}</th>
                            <th>{{ __('reports.total_amount') }}</th>
                            <th>{{ __('reports.amount_paid') }}</th>
                            <th>{{ __('reports.balance') }}</th>
                            <th class="no-sort">{{ __('reports.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $data)
                            <tr>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email ?? __('N/A') }}</td>
                                <td>{{ $data->phone ?? __('N/A') }}</td>
                                <td>{{ $data->purchase_count }}</td>
                                <td>{{ show_amount($data->total_amount, 2) }}</td>
                                <td>{{ show_amount($data->total_paid, 2) }}</td>
                                <td>{{ show_amount($data->total_due, 2) }}</td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('suppliers.show', $data->id) }}">
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
