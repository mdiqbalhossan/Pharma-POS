@extends('layouts.app')

@section('title', __('purchase.create'))

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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
@endpush

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>{{ __('purchase.create') }}</h4>
                <h6>{{ __('purchase.create_new') }}</h6>
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

    <form id="purchaseCreateForm" action="{{ route('purchases.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="date">{{ __('purchase.date') }} <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="date" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="supplier_id">{{ __('purchase.supplier.title') }} <span
                                    class="text-danger">*</span></label>
                            <select name="supplier_id" id="supplier_id" class="form-control select2" required>
                                <option value="">{{ __('purchase.select_supplier') }}</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="purchase_status">{{ __('purchase.status') }} <span
                                    class="text-danger">*</span></label>
                            <select name="purchase_status" id="purchase_status" class="form-control select2" required>
                                <option value="received">{{ __('purchase.received') }}</option>
                                <option value="pending">{{ __('purchase.pending') }}</option>
                                <option value="ordered">{{ __('purchase.ordered') }}</option>
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
                                        <th><i data-feather="trash-2"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Items will be added dynamically via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                        <div class="alert alert-info mt-3 empty-table-message">
                            {{ __('purchase.no_items_added') }}
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="note">{{ __('purchase.note') }}</label>
                                    <textarea name="note" id="note" class="form-control" rows="5"></textarea>
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
                                        <input type="text" name="subtotal" id="subtotal" class="form-control-plaintext"
                                            value="0.00" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="total_tax"
                                        class="col-sm-6 col-form-label">{{ __('purchase.total_tax') }}</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="total_tax" id="total_tax"
                                            class="form-control-plaintext" value="0.00" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="shipping"
                                        class="col-sm-6 col-form-label">{{ __('purchase.shipping') }}</label>
                                    <div class="col-sm-6">
                                        <input type="number" name="shipping" id="shipping" class="form-control"
                                            value="0" min="0" step="0.01">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="discount"
                                        class="col-sm-6 col-form-label">{{ __('purchase.discount') }}</label>
                                    <div class="col-sm-6">
                                        <input type="number" name="discount" id="discount" class="form-control"
                                            value="0" min="0" step="0.01">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="grand_total"
                                        class="col-sm-6 col-form-label">{{ __('purchase.grand_total') }}</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="grand_total" id="grand_total"
                                            class="form-control-plaintext" value="0.00" readonly>
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
                                <option value="cash">{{ __('purchase.payment_method_cash') }}</option>
                                <option value="bank_transfer">{{ __('purchase.payment_method_bank') }}</option>
                                <option value="cheque">{{ __('purchase.payment_method_cheque') }}</option>
                                <option value="other">{{ __('purchase.payment_method_other') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="paid_amount">{{ __('purchase.paid_amount') }}</label>
                            <input type="number" name="paid_amount" id="paid_amount" class="form-control"
                                value="0" min="0" step="0.01">
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="payment_note">{{ __('purchase.payment_note') }}</label>
                            <textarea name="payment_note" id="payment_note" class="form-control" rows="1"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">{{ __('purchase.action.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Medicine Item Template (hidden) -->
    <table class="d-none">
        <tr id="item-row-template" class="purchase-item">
            <td>
                <input type="hidden" name="medicine_id[]" class="medicine-id">
                <span class="medicine-name"></span>
            </td>
            <td>
                <input type="text" name="batch_no[]" class="form-control" required>
            </td>
            <td>
                <input type="date" name="expiry_date[]" class="form-control" required>
            </td>
            <td>
                <input type="number" name="quantity[]" class="form-control quantity" value="1" min="1"
                    required>
            </td>
            <td>
                <input type="number" name="unit_price[]" class="form-control unit-price" value="0" min="0"
                    step="0.01" required>
            </td>
            <td>
                <input type="number" name="discount[]" class="form-control discount" value="0" min="0"
                    max="100" step="0.01">
            </td>
            <td>
                <input type="number" name="tax[]" class="form-control tax" value="0" min="0"
                    max="100" step="0.01">
            </td>
            <td>
                <span class="subtotal">0.00</span>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger remove-item">
                    <i data-feather="trash-2"></i>
                </button>
            </td>
        </tr>
    </table>

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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
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
    <!-- Purchase Create JS -->
    <script src="{{ asset('assets/js/pages/purchase-create.js') }}"></script>
@endpush
