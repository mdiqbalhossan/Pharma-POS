@extends('layouts.app')

@section('title', __('purchase.edit'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
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

    <form id="purchaseEditForm" action="{{ route('purchases.update', $purchase->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="date">{{ __('purchase.date') }} <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="date" class="form-control"
                                value="{{ $purchase->date }}" required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
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
                        <div class="form-group">
                            <label for="purchase_status">{{ __('purchase.status') }} <span
                                    class="text-danger">*</span></label>
                            <select name="purchase_status" id="purchase_status" class="form-control select2" required>
                                <option value="received" {{ $purchase->purchase_status == 'received' ? 'selected' : '' }}>
                                    {{ __('purchase.received') }}</option>
                                <option value="pending" {{ $purchase->purchase_status == 'pending' ? 'selected' : '' }}>
                                    {{ __('purchase.pending') }}</option>
                                <option value="ordered" {{ $purchase->purchase_status == 'ordered' ? 'selected' : '' }}>
                                    {{ __('purchase.ordered') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="medicine_search">{{ __('purchase.add_medicine') }}</label>
                            <select id="medicine_search" class="form-control select2"
                                data-placeholder="{{ __('purchase.medicine_placeholder') }}">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-stripped" id="purchase-items-table">
                                <thead>
                                    <tr>
                                        <th width="20%">{{ __('purchase.medicine') }}</th>
                                        <th>{{ __('purchase.batch_no') }}</th>
                                        <th>{{ __('purchase.expiry_date') }}</th>
                                        <th>{{ __('purchase.qty') }}</th>
                                        <th>{{ __('purchase.purchase_price') }}</th>
                                        <th>{{ __('purchase.discount') }} (%)</th>
                                        <th>{{ __('purchase.tax') }} (%)</th>
                                        <th>{{ __('purchase.subtotal') }}</th>
                                        <th><i data-feather="trash-2"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase->medicines as $key => $medicine)
                                        <tr class="purchase-item">
                                            <td>
                                                <input type="hidden" name="medicine_id[]" value="{{ $medicine->id }}">
                                                <span class="medicine-name">{{ $medicine->name }}</span>
                                            </td>
                                            <td>
                                                <input type="text" name="batch_no[]" class="form-control"
                                                    value="{{ $medicine->pivot->batch_no }}" required>
                                            </td>
                                            <td>
                                                <input type="date" name="expiry_date[]" class="form-control"
                                                    value="{{ $medicine->pivot->expiry_date }}" required>
                                            </td>
                                            <td>
                                                <input type="number" name="quantity[]" class="form-control quantity"
                                                    value="{{ $medicine->pivot->quantity }}" min="1" required>
                                            </td>
                                            <td>
                                                <input type="number" name="unit_price[]" class="form-control unit-price"
                                                    value="{{ $medicine->pivot->unit_price }}" min="0"
                                                    step="0.01" required>
                                            </td>
                                            <td>
                                                <input type="number" name="discount[]" class="form-control discount"
                                                    value="{{ $medicine->pivot->discount }}" min="0" max="100"
                                                    step="0.01">
                                            </td>
                                            <td>
                                                <input type="number" name="tax[]" class="form-control tax"
                                                    value="{{ $medicine->pivot->tax }}" min="0" max="100"
                                                    step="0.01">
                                            </td>
                                            <td>
                                                <span class="subtotal">
                                                    {{ number_format($medicine->pivot->subtotal, 2) }}</span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger remove-item">
                                                    <i data-feather="trash-2"></i>
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
                                    <label for="note">{{ __('purchase.note') }}</label>
                                    <textarea name="note" id="note" class="form-control" rows="5">{{ $purchase->note }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div class="form-group row mb-3">
                                    <label for="subtotal"
                                        class="col-sm-6 col-form-label">{{ __('purchase.subtotal') }}</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="subtotal" id="subtotal"
                                            class="form-control-plaintext"
                                            value="{{ number_format($purchase->subtotal, 2) }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="total_tax"
                                        class="col-sm-6 col-form-label">{{ __('purchase.total_tax') }}</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="total_tax" id="total_tax"
                                            class="form-control-plaintext"
                                            value="{{ number_format($purchase->total_tax, 2) }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="shipping"
                                        class="col-sm-6 col-form-label">{{ __('purchase.shipping') }}</label>
                                    <div class="col-sm-6">
                                        <input type="number" name="shipping" id="shipping" class="form-control"
                                            value="{{ $purchase->shipping }}" min="0" step="0.01">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="discount"
                                        class="col-sm-6 col-form-label">{{ __('purchase.discount') }}</label>
                                    <div class="col-sm-6">
                                        <input type="number" name="discount" id="discount" class="form-control"
                                            value="{{ $purchase->discount }}" min="0" step="0.01">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="grand_total"
                                        class="col-sm-6 col-form-label">{{ __('purchase.grand_total') }}</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="grand_total" id="grand_total"
                                            class="form-control-plaintext"
                                            value="{{ number_format($purchase->grand_total, 2) }}" readonly>
                                    </div>
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
                        <div class="form-group">
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
                        <div class="form-group">
                            <label for="paid_amount">{{ __('purchase.paid_amount') }}</label>
                            <input type="number" name="paid_amount" id="paid_amount" class="form-control"
                                value="{{ $purchase->paid_amount }}" min="0" step="0.01">
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="payment_note">{{ __('purchase.payment_note') }}</label>
                            <textarea name="payment_note" id="payment_note" class="form-control" rows="1">{{ $purchase->payment_note }}</textarea>
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
@endsection

@push('script')
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Toastr JS -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <!-- Purchase Edit JS -->
    <script src="{{ asset('assets/js/pages/purchase-edit.js') }}"></script>
@endpush
