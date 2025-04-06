@extends('layouts.app')

@section('title', 'Create Purchase')

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
                <h4>New Purchase</h4>
                <h6>Create new purchase</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <div class="page-btn">
                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                            class="me-2"></i>Back to Purchase</a>
                </div>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                        data-feather="chevron-up" class="feather-chevron-up"></i></a>
            </li>
        </ul>
    </div>

    <form action="{{ route('purchases.store') }}" method="POST" id="purchase-form">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="input-blocks add-product mb-3">
                            <label for="supplier_id">Supplier <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-lg-10 col-sm-10 col-10">
                                    <select class="select" id="supplier_id" name="supplier_id" required>
                                        <option value="">Select Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                    <div class="add-icon tab">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#supplierModal"><i
                                                data-feather="plus-circle" class="feather-plus-circles"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="input-blocks">
                            <label for="date">Purchase Date <span class="text-danger">*</span></label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" id="date" name="date" class="datetimepicker"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="input-blocks mb-3">
                            <label for="invoice_no">Reference/Invoice No <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="invoice_no" name="invoice_no"
                                value="{{ $invoiceNumber }}" required readonly>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="input-blocks mb-3">
                            <label for="purchase_type">Purchase Type <span class="text-danger">*</span></label>
                            <select class="select" id="purchase_type" name="purchase_type" required>
                                <option value="purchase">Purchase</option>
                                <option value="purchase_order">Purchase Order</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-12">
                        <div class="card bg-light shadow-none border">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-blocks">
                                            <label for="medicine_search">Medicine Name</label>
                                            <input type="text" id="medicine_search"
                                                placeholder="Please type medicine name or barcode and select">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table" id="purchase-table">
                                                <thead>
                                                    <tr>
                                                        <th>Medicine</th>
                                                        <th class="w-20">Batch No</th>
                                                        <th>Expiry Date</th>
                                                        <th>Qty</th>
                                                        <th>MRP</th>
                                                        <th>Purchase Price</th>
                                                        <th>Discount %</th>
                                                        <th>Tax %</th>
                                                        <th>Tax Amount</th>
                                                        <th>Subtotal</th>
                                                        <th>Row Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <!-- Items will be added dynamically -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="card shadow-none border mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-blocks mb-3">
                                            <label for="order_tax">Order Tax (%)</label>
                                            <input type="number" step="0.01" id="order_tax" name="order_tax"
                                                class="form-control" value="0" min="0">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-blocks mb-3">
                                            <label for="order_discount">Discount</label>
                                            <input type="number" step="0.01" id="order_discount"
                                                name="order_discount" class="form-control" value="0"
                                                min="0">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-blocks mb-3">
                                            <label for="shipping_cost">Shipping Cost</label>
                                            <input type="number" step="0.01" id="shipping_cost" name="shipping_cost"
                                                class="form-control" value="0" min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-blocks">
                                            <label for="summernote">Note</label>
                                            <textarea id="summernote" name="note" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-none border">
                            <div class="card-body">
                                <div class="purchase-total">
                                    <div class="purchase-total-item d-flex justify-content-between mb-3">
                                        <span>Subtotal:</span>
                                        <span>$<span id="subtotal-value">0.00</span></span>
                                        <input type="hidden" id="subtotal-input" name="subtotal" value="0">
                                    </div>
                                    <div class="purchase-total-item d-flex justify-content-between mb-3">
                                        <span>Tax:</span>
                                        <span>$<span id="tax-value">0.00</span></span>
                                        <input type="hidden" id="tax-input" name="tax_amount" value="0">
                                    </div>
                                    <div class="purchase-total-item d-flex justify-content-between mb-3">
                                        <span>Discount:</span>
                                        <span>$<span id="discount-value">0.00</span></span>
                                        <input type="hidden" id="discount-input" value="0">
                                    </div>
                                    <div
                                        class="purchase-total-item d-flex justify-content-between mb-3 border-top border-bottom py-2">
                                        <h5>Grand Total:</h5>
                                        <h5>$<span id="grand-total-value">0.00</span></h5>
                                        <input type="hidden" id="grand-total-input" name="grand_total" value="0">
                                    </div>
                                    <div class="purchase-total-item d-flex justify-content-between mb-3">
                                        <h6>Paid Amount:</h6>
                                        <div>
                                            <input type="number" step="0.01" id="paid_amount" name="paid_amount"
                                                class="form-control" value="0" min="0" required>
                                        </div>
                                    </div>
                                    <div class="purchase-total-item d-flex justify-content-between mb-3 border-top pt-2">
                                        <h6>Due Amount:</h6>
                                        <h6>$<span id="due-amount-value">0.00</span></h6>
                                        <input type="hidden" id="due_amount" name="due_amount" value="0">
                                    </div>
                                    <div class="input-blocks mb-3">
                                        <label for="payment_method">Payment Method</label>
                                        <select class="select" id="payment_method" name="payment_method">
                                            <option value="Cash">Cash</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                            <option value="Credit Card">Credit Card</option>
                                            <option value="Cheque">Cheque</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-4">
                <div class="btn-group">
                    <a href="{{ route('purchases.index') }}" class="btn btn-danger me-2">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Purchase
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Supplier Modal -->
    <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierModalLabel">Add New Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="supplier-form">
                        <div class="input-blocks mb-3">
                            <label for="supplier_name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="supplier_name" required>
                        </div>
                        <div class="input-blocks mb-3">
                            <label for="supplier_email">Email</label>
                            <input type="email" class="form-control" id="supplier_email">
                        </div>
                        <div class="input-blocks mb-3">
                            <label for="supplier_phone">Phone</label>
                            <input type="text" class="form-control" id="supplier_phone">
                        </div>
                        <div class="input-blocks mb-3">
                            <label for="supplier_address">Address</label>
                            <textarea class="form-control" id="supplier_address" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="add-supplier-btn">Add Supplier</button>
                </div>
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
    <!-- Summernote JS -->
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- Toastr JS -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <!-- jQuery UI JS -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Custom Purchase JS -->
    <script src="{{ asset('assets/js/pages/purchase.js') }}"></script>
@endpush
