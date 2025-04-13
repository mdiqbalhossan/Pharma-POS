@extends('layouts.app')

@section('title', __('purchase.purchases'))

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
                <h4>{{ __('purchase.list') }}</h4>
                <h6>{{ __('purchase.manage_purchases') }}</h6>
            </div>
        </div>

        <div class="d-flex purchase-pg-btn">
            <div class="page-btn">
                <a href="{{ route('purchases.create') }}" class="btn btn-added"><i data-feather="plus-circle"
                        class="me-2"></i>{{ __('purchase.add_new') }}</a>
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
                        <option>{{ __('purchase.sort_date') }}</option>
                        <option>{{ __('purchase.newest') }}</option>
                        <option>{{ __('purchase.oldest') }}</option>
                    </select>
                </div>
            </div>
            <!-- /Filter -->
            <div class="card" id="filter_inputs">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="input-blocks">
                                <i data-feather="user" class="info-img"></i>
                                <select class="select">
                                    <option>{{ __('purchase.choose_supplier') }}</option>
                                    <option>{{ __('purchase.vendor.apex_computers') }}</option>
                                    <option>{{ __('purchase.vendor.beats_headphones') }}</option>
                                    <option>{{ __('purchase.vendor.dazzle_shoes') }}</option>
                                    <option>{{ __('purchase.vendor.best_accessories') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="input-blocks">
                                <i data-feather="stop-circle" class="info-img"></i>
                                <select class="select">
                                    <option>{{ __('purchase.choose_status') }}</option>
                                    <option>{{ __('purchase.status.received') }}</option>
                                    <option>{{ __('purchase.status.ordered') }}</option>
                                    <option>{{ __('purchase.status.pending') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="input-blocks">
                                <i data-feather="file" class="info-img"></i>
                                <select class="select">
                                    <option>{{ __('purchase.enter_reference') }}</option>
                                    <option>{{ __('purchase.reference.pt001') }}</option>
                                    <option>{{ __('purchase.reference.pt002') }}</option>
                                    <option>{{ __('purchase.reference.pt003') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="input-blocks">
                                <i class="fas fa-money-bill info-img"></i>
                                <select class="select">
                                    <option>{{ __('purchase.choose_payment_status') }}</option>
                                    <option>{{ __('purchase.payment_status.paid') }}</option>
                                    <option>{{ __('purchase.payment_status.partial') }}</option>
                                    <option>{{ __('purchase.payment_status.unpaid') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 ms-auto">
                            <div class="input-blocks">
                                <a class="btn btn-filters ms-auto"><i data-feather="search" class="feather-search"></i>
                                    {{ __('purchase.search') }}</a>
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
                            <th>{{ __('purchase.supplier_name') }}</th>
                            <th>{{ __('purchase.reference') }}</th>
                            <th>{{ __('purchase.date') }}</th>
                            <th>{{ __('purchase.type') }}</th>
                            <th>{{ __('purchase.grand_total') }}</th>
                            <th>{{ __('purchase.paid') }}</th>
                            <th>{{ __('purchase.due') }}</th>
                            <th>{{ __('purchase.payment_status.title') }}</th>
                            <th class="no-sort">{{ __('purchase.action.title') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->supplier ? $purchase->supplier->name : 'N/A' }}</td>
                                <td>{{ $purchase->invoice_no }}</td>
                                <td>{{ \Carbon\Carbon::parse($purchase->date)->format('d M Y') }}</td>
                                <td>
                                    @if ($purchase->type == 'purchase')
                                        <span class="badges status-badge">{{ __('purchase.purchase') }}</span>
                                    @elseif($purchase->type == 'purchase_order')
                                        <span
                                            class="badges status-badge ordered">{{ __('purchase.purchase_order') }}</span>
                                    @endif
                                </td>
                                <td>{{ show_amount($purchase->grand_total) }}</td>
                                <td>{{ show_amount($purchase->paid_amount) }}</td>
                                <td>{{ show_amount($purchase->due_amount) }}</td>
                                <td>
                                    @if ($purchase->due_amount <= 0)
                                        <span class="badge-linesuccess">{{ __('purchase.payment_status.paid') }}</span>
                                    @elseif($purchase->paid_amount > 0 && $purchase->due_amount > 0)
                                        <span class="badges-warning">{{ __('purchase.payment_status.partial') }}</span>
                                    @else
                                        <span
                                            class="badge badge-linedangered">{{ __('purchase.payment_status.unpaid') }}</span>
                                    @endif
                                </td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('purchases.show', $purchase->id) }}"
                                            title="{{ __('purchase.action.view') }}">
                                            <i data-feather="eye" class="action-eye"></i>
                                        </a>
                                        <a class="me-2 p-2" href="{{ route('purchases.edit', $purchase->id) }}"
                                            title="{{ __('purchase.action.edit') }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        @if ($purchase->type == 'purchase')
                                            <a class="me-2 p-2" href="{{ route('purchases.return', $purchase->id) }}"
                                                title="{{ __('purchase.action.return') }}">
                                                <i data-feather="corner-up-left" class="feather-edit"></i>
                                            </a>
                                        @endif
                                        <a class="confirm-text p-2" href="javascript:void(0);" data-bs-toggle="tooltip"
                                            title="{{ __('purchase.action.delete') }}" data-id="{{ $purchase->id }}">
                                            <i data-feather="trash-2" class="feather-trash-2"></i>
                                        </a>
                                        <form id="delete-form-{{ $purchase->id }}"
                                            action="{{ route('purchases.destroy', $purchase->id) }}" method="POST"
                                            style="display: none;">
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
