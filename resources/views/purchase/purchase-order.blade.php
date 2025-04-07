@extends('layouts.app')

@section('title', __('purchase.order'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
@endpush

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>{{ __('purchase.order') }}</h4>
                <h6>{{ __('purchase.order_details') }}</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <div class="page-btn">
                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                            class="me-2"></i>{{ __('purchase.back_to') }}</a>
                </div>
            </li>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="convertPurchaseOrderForm" action="{{ route('purchases.convert-purchase-order', $purchase->id) }}"
                method="POST">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <p class="mb-0">{{ __('purchase.converting_order', ['invoice' => $purchase->invoice_no]) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="supplier_id">{{ __('purchase.supplier') }}</label>
                            <input type="text" class="form-control" value="{{ $purchase->supplier->name }}" readonly>
                            <input type="hidden" name="supplier_id" value="{{ $purchase->supplier_id }}">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="date">{{ __('purchase.date') }} <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="date" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="status">{{ __('purchase.status') }} <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control select2" required>
                                <option value="received">{{ __('purchase.received') }}</option>
                                <option value="pending">{{ __('purchase.pending') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="purchase-items-table">
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase->medicines as $medicine)
                                        <tr>
                                            <td>
                                                {{ $medicine->name }}
                                                <input type="hidden" name="medicine_id[]" value="{{ $medicine->id }}">
                                            </td>
                                            <td>
                                                <input type="text" name="batch_no[]" class="form-control"
                                                    value="{{ $medicine->pivot->batch_no ?? '' }}" required>
                                            </td>
                                            <td>
                                                <input type="date" name="expiry_date[]" class="form-control"
                                                    value="{{ date('Y-m-d', strtotime('+1 year')) }}" required>
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
                                                    value="{{ $medicine->pivot->discount ?? 0 }}" min="0"
                                                    max="100" step="0.01">
                                            </td>
                                            <td>
                                                <input type="number" name="tax[]" class="form-control tax"
                                                    value="{{ $medicine->pivot->tax ?? 0 }}" min="0" max="100"
                                                    step="0.01">
                                            </td>
                                            <td>
                                                <span class="subtotal">
                                                    {{ number_format($medicine->pivot->subtotal, 2) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="note">{{ __('purchase.note') }}</label>
                            <textarea name="note" id="note" class="form-control" rows="4">{{ $purchase->note }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border">
                            <div class="card-body">
                                <div class="form-group row mb-3">
                                    <label for="shipping"
                                        class="col-md-4 col-form-label">{{ __('purchase.shipping') }}</label>
                                    <div class="col-md-8">
                                        <input type="number" name="shipping" id="shipping" class="form-control"
                                            value="{{ $purchase->shipping ?? 0 }}" min="0" step="0.01">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="discount"
                                        class="col-md-4 col-form-label">{{ __('purchase.discount') }}</label>
                                    <div class="col-md-8">
                                        <input type="number" name="discount" id="discount" class="form-control"
                                            value="{{ $purchase->discount ?? 0 }}" min="0" step="0.01">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="payment_method"
                                        class="col-md-4 col-form-label">{{ __('purchase.payment_method') }}</label>
                                    <div class="col-md-8">
                                        <select name="payment_method" id="payment_method" class="form-control select2"
                                            required>
                                            <option value="cash">{{ __('purchase.payment_method_cash') }}</option>
                                            <option value="bank_transfer">{{ __('purchase.payment_method_bank') }}
                                            </option>
                                            <option value="cheque">{{ __('purchase.payment_method_cheque') }}</option>
                                            <option value="other">{{ __('purchase.payment_method_other') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="paid_amount"
                                        class="col-md-4 col-form-label">{{ __('purchase.paid_amount') }}</label>
                                    <div class="col-md-8">
                                        <input type="number" name="paid_amount" id="paid_amount" class="form-control"
                                            value="0" min="0" step="0.01">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('purchase.action.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('purchase.convert') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Toastr JS -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
