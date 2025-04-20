@extends('layouts.app')

@section('title', __('purchase_return.purchase_return_list'))

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
                <h4>{{ __('purchase_return.purchase_return_list') }}</h4>
                <h6>{{ __('purchase_return.manage_purchase_returns') }}</h6>
            </div>
        </div>
    </div>

    <!-- Purchase Return list -->
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
                        <option>{{ __('purchase_return.sort_by_date') }}</option>
                        <option>{{ __('purchase_return.newest') }}</option>
                        <option>{{ __('purchase_return.oldest') }}</option>
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
                                    <option>{{ __('purchase_return.choose_supplier_name') }}</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="input-blocks">
                                <i class="fas fa-money-bill info-img"></i>
                                <select class="select">
                                    <option>{{ __('purchase_return.choose_payment_status') }}</option>
                                    <option value="paid">{{ __('purchase_return.paid') }}</option>
                                    <option value="partial">{{ __('purchase_return.partial') }}</option>
                                    <option value="unpaid">{{ __('purchase_return.unpaid') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 ms-auto">
                            <div class="input-blocks">
                                <a class="btn btn-filters ms-auto"> <i data-feather="search" class="feather-search"></i>
                                    {{ __('purchase_return.search') }} </a>
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
                            <th>{{ __('purchase_return.purchase_invoice') }}</th>
                            <th>{{ __('purchase_return.medicine') }}</th>
                            <th>{{ __('purchase_return.date') }}</th>
                            <th>{{ __('purchase_return.returned_quantity') }}</th>
                            <th>{{ __('purchase_return.unit_price') }}</th>
                            <th>{{ __('purchase_return.grand_total') }}</th>
                            <th>{{ __('purchase_return.paid') }}</th>
                            <th>{{ __('purchase_return.due') }}</th>
                            <th>{{ __('purchase_return.payment_status') }}</th>
                            <th class="no-sort">{{ __('purchase_return.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseReturns as $return)
                            <tr>
                                <td>{{ $return->purchase ? $return->purchase->invoice_no : __('purchase_return.na') }}</td>
                                <td>{{ $return->medicine ? $return->medicine->name : __('purchase_return.na') }}</td>
                                <td>{{ \Carbon\Carbon::parse($return->created_at)->format('d M Y') }}</td>
                                <td>{{ $return->quantity }} {{ $return->medicine ? $return->medicine->unit->name : '' }}
                                </td>
                                <td>{{ show_amount($return->unit_price) }}</td>
                                <td>{{ show_amount($return->grand_total) }}</td>
                                <td>{{ show_amount($return->paid_amount) }}</td>
                                <td>{{ show_amount($return->due_amount) }}</td>
                                <td>
                                    @if ($return->due_amount <= 0)
                                        <span class="badge-linesuccess">{{ __('purchase_return.paid') }}</span>
                                    @elseif($return->paid_amount > 0 && $return->due_amount > 0)
                                        <span class="badges-warning">{{ __('purchase_return.partial') }}</span>
                                    @else
                                        <span class="badge badge-linedangered">{{ __('purchase_return.unpaid') }}</span>
                                    @endif
                                </td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('purchase-returns.show', $return->id) }}">
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
    <!-- /Purchase Return list -->
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
