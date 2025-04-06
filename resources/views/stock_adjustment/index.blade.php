@extends('layouts.app')

@section('title', 'Stock Adjustments')

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
                <h4>Stock Adjustments</h4>
                <h6>Manage your stock adjustments</h6>
            </div>
        </div>

        <div class="d-flex purchase-pg-btn">
            <div class="page-btn">
                <a href="{{ route('stock-adjustments.create') }}" class="btn btn-added"><i data-feather="plus-circle"
                        class="me-2"></i>Add New Adjustment</a>
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
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="input-blocks">
                                <i data-feather="package" class="info-img"></i>
                                <select class="select">
                                    <option>Choose Medicine</option>
                                    <!-- Medicines would be populated here -->
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="input-blocks">
                                <i data-feather="stop-circle" class="info-img"></i>
                                <select class="select">
                                    <option>Choose Type</option>
                                    <option>Addition</option>
                                    <option>Reduction</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 ms-auto">
                            <div class="input-blocks">
                                <a class="btn btn-filters ms-auto"><i data-feather="search" class="feather-search"></i>
                                    Search</a>
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
                            <th>Medicine Name</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Reason</th>
                            <th>Created By</th>
                            <th class="no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stockAdjustments as $adjustment)
                            <tr>
                                <td>{{ $adjustment->medicine ? $adjustment->medicine->name : 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($adjustment->date)->format('d M Y') }}</td>
                                <td>
                                    @if ($adjustment->type == 'addition')
                                        <span class="badges status-badge">Addition</span>
                                    @elseif($adjustment->type == 'reduction')
                                        <span class="badges status-badge ordered">Reduction</span>
                                    @endif
                                </td>
                                <td>{{ $adjustment->quantity }}</td>
                                <td>{{ $adjustment->reason }}</td>
                                <td>{{ $adjustment->creator ? $adjustment->creator->name : 'N/A' }}</td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('stock-adjustments.show', $adjustment->id) }}">
                                            <i data-feather="eye" class="action-eye"></i>
                                        </a>
                                        <a class="me-2 p-2" href="{{ route('stock-adjustments.edit', $adjustment->id) }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="confirm-text p-2" href="javascript:void(0);" data-bs-toggle="tooltip"
                                            title="Delete" data-id="{{ $adjustment->id }}">
                                            <i data-feather="trash-2" class="feather-trash-2"></i>
                                        </a>
                                        <form id="delete-form-{{ $adjustment->id }}"
                                            action="{{ route('stock-adjustments.destroy', $adjustment->id) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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
