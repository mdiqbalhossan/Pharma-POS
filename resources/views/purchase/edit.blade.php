@extends('layouts.app')

@section('title', __('purchase.edit'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <!-- Summernote CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
@endpush

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>{{ __('purchase.edit') }}</h4>
                <h6>{{ __('purchase.edit_purchase') }}</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <div class="page-btn">
                    <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-secondary me-0"><i
                            data-feather="arrow-left" class="me-1"></i>{{ __('purchase.back_to') }}</a>
                </div>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('purchase.collapse') }}"
                    id="collapse-header"><i data-feather="chevron-up" class="feather-chevron-up"></i></a>
            </li>
        </ul>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="purchase-form" action="{{ route('purchases.update', $purchase->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body add-product">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="input-blocks">
                            <label for="date">{{ __('index.Date') }} <span class="text-danger">*</span></label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" id="date" name="date" class="datetimepicker"
                                    value="{{ $purchase->date }}" required>
                            </div>
                            @error('date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="input-blocks">
                            <label for="supplier_id">{{ __('purchase.supplier.title') }} <span
                                    class="text-danger">*</span></label>
                            <select name="supplier_id" id="supplier_id" class="form-control select2" required>
                                <option value="">{{ __('purchase.select_supplier') }}</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="input-blocks">
                            <label for="purchase_type">{{ __('purchase.type') }} <span class="text-danger">*</span></label>
                            <select name="purchase_type" id="purchase_type" class="form-control select2" required>
                                <option value="purchase" {{ $purchase->type == 'purchase' ? 'selected' : '' }}>
                                    {{ __('purchase.purchase') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-blocks search-form seacrh-barcode-item">
                            <div class="searchInput">
                                <label class="form-label">{{ __('medicine.product') }}</label>
                                <input type="text" class="form-control" id="medicine_search"
                                    placeholder="{{ __('medicine.search_product_by_name_or_code') }}">
                                <div class="resultBox">
                                </div>
                                <div class="icon"><i class="fas fa-search"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="purchase-table">
                                <thead>
                                    <tr>
                                        <th width="20%">{{ __('purchase.medicine') }}</th>
                                        <th>{{ __('purchase.batch_no') }}</th>
                                        <th>{{ __('purchase.expiry_date') }}</th>
                                        <th>{{ __('purchase.qty') }}</th>
                                        <th>{{ __('purchase.sale_price') }}</th>
                                        <th>{{ __('purchase.purchase_price') }}</th>
                                        <th>{{ __('purchase.discount') }} (%)</th>
                                        <th>{{ __('purchase.tax') }} (%)</th>
                                        <th>{{ __('purchase.tax_amount') }}</th>
                                        <th>{{ __('purchase.subtotal') }}</th>
                                        <th>{{ __('purchase.total') }}</th>
                                        <th><i class="fas fa-trash"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase->medicines as $medicine)
                                        <tr data-medicine-id="{{ $medicine->id }}">
                                            <td>
                                                {{ $medicine->name }}
                                                <input type="hidden" name="medicine_id[]" value="{{ $medicine->id }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control batch-no w-150px"
                                                    name="batch_no[]" value="{{ $medicine->pivot->batch_no }}" required>
                                            </td>
                                            <td>
                                                <input type="date" class="form-control expiry-date" name="expiry_date[]"
                                                    value="{{ $medicine->pivot->expiry_date }}" required>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control medicine-qty w-100px"
                                                    name="quantity[]" value="{{ $medicine->pivot->quantity }}"
                                                    min="1" required>
                                            </td>
                                            <td>
                                                <input type="number" step="0.01"
                                                    class="form-control sale-price w-100px" name="sale_price[]"
                                                    value="{{ $medicine->sale_price }}" required>
                                            </td>
                                            <td>
                                                <input type="number" step="0.01"
                                                    class="form-control unit-price w-100px" name="unit_price[]"
                                                    value="{{ $medicine->pivot->unit_price }}" required>
                                            </td>
                                            <td>
                                                <input type="number" step="0.01"
                                                    class="form-control discount w-100px" name="discount[]"
                                                    value="{{ $medicine->pivot->discount }}">
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" class="form-control tax w-100px"
                                                    name="tax[]" value="{{ $medicine->pivot->tax }}">
                                            </td>
                                            <td>
                                                <span
                                                    class="tax-amount">{{ show_amount($medicine->pivot->total_tax) }}</span>
                                                <input type="hidden" name="tax_amount[]" class="tax-amount-input"
                                                    value="{{ $medicine->pivot->total_tax }}">
                                            </td>
                                            <td>
                                                <span
                                                    class="subtotal">{{ show_amount($medicine->pivot->total_price) }}</span>
                                                <input type="hidden" name="subtotal[]" class="subtotal-input"
                                                    value="{{ $medicine->pivot->total_price }}">
                                            </td>
                                            <td>
                                                <span
                                                    class="row-total">{{ show_amount($medicine->pivot->total_tax) }}</span>
                                                <input type="hidden" name="row_total[]" class="row-total-input"
                                                    value="{{ $medicine->pivot->total_tax }}">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger remove-medicine">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="summernote">{{ __('purchase.note') }}</label>
                                    <textarea name="note" id="summernote" class="form-control">{{ $purchase->note }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th>{{ __('purchase.subtotal') }}</th>
                                            <td>
                                                <span id="subtotal-value">{{ show_amount($purchase->subtotal) }}</span>
                                                <input type="hidden" name="subtotal" id="subtotal-input"
                                                    value="{{ $purchase->subtotal }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('purchase.order_tax') }}</th>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" step="0.01" min="0"
                                                        class="form-control" id="order_tax" name="order_tax"
                                                        value="{{ $purchase->order_tax }}">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('purchase.tax_amount') }}</th>
                                            <td>
                                                <span id="tax-value">{{ show_amount($purchase->tax_amount) }}</span>
                                                <input type="hidden" name="tax_amount" id="tax-input"
                                                    value="{{ $purchase->tax_amount }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('purchase.order_discount') }}</th>
                                            <td>
                                                <input type="number" step="0.01" min="0" class="form-control"
                                                    id="order_discount" name="order_discount"
                                                    value="{{ $purchase->order_discount }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('purchase.shipping_cost') }}</th>
                                            <td>
                                                <input type="number" step="0.01" min="0" class="form-control"
                                                    id="shipping_cost" name="shipping_cost"
                                                    value="{{ $purchase->shipping_cost }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('purchase.discount_amount') }}</th>
                                            <td>
                                                <span
                                                    id="discount-value">{{ show_amount($purchase->discount_amount) }}</span>
                                                <input type="hidden" name="discount_amount" id="discount-input"
                                                    value="{{ $purchase->discount_amount }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('purchase.grand_total') }}</th>
                                            <td>
                                                <span
                                                    id="grand-total-value">{{ show_amount($purchase->grand_total) }}</span>
                                                <input type="hidden" name="grand_total" id="grand-total-input"
                                                    value="{{ $purchase->grand_total }}">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <h5>{{ __('purchase.payment_info') }}</h5>
                        <hr>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="input-blocks">
                            <label for="payment_method">{{ __('purchase.payment_method') }} <span
                                    class="text-danger">*</span></label>
                            <select name="payment_method" id="payment_method" class="form-control select2" required>
                                <option value="cash" {{ $purchase->payment_method == 'cash' ? 'selected' : '' }}>
                                    {{ __('purchase.payment_method_cash') }}</option>
                                <option value="bank_transfer"
                                    {{ $purchase->payment_method == 'bank_transfer' ? 'selected' : '' }}>
                                    {{ __('purchase.payment_method_bank') }}</option>
                                <option value="cheque" {{ $purchase->payment_method == 'cheque' ? 'selected' : '' }}>
                                    {{ __('purchase.payment_method_cheque') }}</option>
                                <option value="other" {{ $purchase->payment_method == 'other' ? 'selected' : '' }}>
                                    {{ __('purchase.payment_method_other') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="input-blocks">
                            <label for="paid_amount">{{ __('purchase.paid_amount') }}</label>
                            <input type="number" name="paid_amount" id="paid_amount" class="form-control"
                                value="{{ $purchase->paid_amount }}" min="0" step="0.01">
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="input-blocks">
                            <label for="account_id">{{ __('purchase.account') }} <span
                                    class="text-danger">*</span></label>
                            <select name="account_id" id="account_id" class="form-control select2" required>
                                <option value="">{{ __('purchase.select_account') }}</option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}"
                                        {{ $purchase->account_id == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="input-blocks">
                            <label for="payment_note">{{ __('purchase.payment_note') }}</label>
                            <textarea name="payment_note" id="payment_note" class="form-control" rows="1">{{ $purchase->payment_note }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="input-blocks">
                            <label for="due_amount">{{ __('purchase.due_amount') }}</label>
                            <div class="input-group">
                                <span id="due-amount-value">{{ number_format($purchase->due_amount, 2) }}</span>
                                <input type="hidden" name="due_amount" id="due_amount"
                                    value="{{ $purchase->due_amount }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">{{ __('purchase.action.update') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Supplier Modal -->
    <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierModalLabel">{{ __('purchase.supplier.add_new') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="supplier-form">
                        <div class="input-blocks mb-3">
                            <label for="supplier_name">{{ __('purchase.supplier.name') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="supplier_name" required>
                        </div>
                        <div class="input-blocks mb-3">
                            <label for="supplier_email">{{ __('purchase.supplier.email') }}</label>
                            <input type="email" class="form-control" id="supplier_email">
                        </div>
                        <div class="input-blocks mb-3">
                            <label for="supplier_phone">{{ __('purchase.supplier.phone') }}</label>
                            <input type="text" class="form-control" id="supplier_phone">
                        </div>
                        <div class="input-blocks mb-3">
                            <label for="supplier_address">{{ __('purchase.supplier.address') }}</label>
                            <textarea class="form-control" id="supplier_address" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('purchase.supplier.close') }}</button>
                    <button type="button" class="btn btn-primary"
                        id="add-supplier-btn">{{ __('purchase.supplier.add') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- jQuery UI JS -->
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Datetimepicker JS -->
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- Summernote JS -->
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- Toastr JS -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <!-- Purchase JS -->
    <script src="{{ asset('assets/js/pages/purchase.js') }}"></script>
@endpush
