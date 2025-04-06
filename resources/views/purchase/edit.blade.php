@extends('layouts.app')

@section('title', 'Edit Purchase')

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
                <h4>Edit Purchase</h4>
                <h6>Update purchase information</h6>
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

    <form action="{{ route('purchases.update', $purchase->id) }}" method="POST" id="purchase-form">
        @csrf
        @method('PUT')
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
                                            <option value="{{ $supplier->id }}"
                                                {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
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
                                    value="{{ $purchase->date }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="input-blocks mb-3">
                            <label for="invoice_no">Reference/Invoice No <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="invoice_no" name="invoice_no"
                                value="{{ $purchase->invoice_no }}" required>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="input-blocks mb-3">
                            <label for="purchase_type">Purchase Type <span class="text-danger">*</span></label>
                            <select class="select" id="purchase_type" name="purchase_type" required>
                                <option value="purchase" {{ $purchase->type == 'purchase' ? 'selected' : '' }}>Purchase
                                </option>
                                <option value="purchase_order" {{ $purchase->type == 'purchase_order' ? 'selected' : '' }}>
                                    Purchase Order</option>
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
                                                    @foreach ($purchase->medicines as $medicine)
                                                        <tr data-medicine-id="{{ $medicine->id }}">
                                                            <td>
                                                                {{ $medicine->name }}
                                                                <input type="hidden" name="medicine_id[]"
                                                                    value="{{ $medicine->id }}">
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control batch-no w-150px"
                                                                    name="batch_no[]"
                                                                    value="{{ $medicine->pivot->batch_no }}" required>
                                                            </td>
                                                            <td>
                                                                <input type="date" class="form-control expiry-date"
                                                                    name="expiry_date[]"
                                                                    value="{{ $medicine->pivot->expiry_date }}" required>
                                                            </td>
                                                            <td>
                                                                <input type="number"
                                                                    class="form-control medicine-qty w-100px"
                                                                    name="quantity[]"
                                                                    value="{{ $medicine->pivot->quantity }}"
                                                                    min="1" required>
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.01"
                                                                    class="form-control sale-price w-100px" name="mrp[]"
                                                                    value="{{ $medicine->sale_price ?? 0 }}" required>
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.01"
                                                                    class="form-control unit-price w-100px"
                                                                    name="unit_price[]"
                                                                    value="{{ $medicine->pivot->unit_price }}" required>
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.01"
                                                                    class="form-control discount w-100px"
                                                                    name="discount[]"
                                                                    value="{{ $medicine->pivot->discount }}">
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.01"
                                                                    class="form-control tax w-100px" name="tax[]"
                                                                    value="{{ $medicine->pivot->tax ?? 0 }}">
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="tax-amount">{{ $medicine->pivot->total_tax }}</span>
                                                                <input type="hidden" name="tax_amount[]"
                                                                    class="tax-amount-input"
                                                                    value="{{ $medicine->pivot->total_tax }}">
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="subtotal">{{ $medicine->pivot->total_price }}</span>
                                                                <input type="hidden" name="subtotal[]"
                                                                    class="subtotal-input"
                                                                    value="{{ $medicine->pivot->total_price }}">
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="row-total">{{ $medicine->pivot->grand_total }}</span>
                                                                <input type="hidden" name="row_total[]"
                                                                    class="row-total-input"
                                                                    value="{{ $medicine->pivot->grand_total }}">
                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger remove-medicine">
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
                                                class="form-control" value="{{ $purchase->tax }}" min="0">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-blocks mb-3">
                                            <label for="order_discount">Discount</label>
                                            <input type="number" step="0.01" id="order_discount"
                                                name="order_discount" class="form-control"
                                                value="{{ $purchase->discount }}" min="0">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-blocks mb-3">
                                            <label for="shipping_cost">Shipping Cost</label>
                                            <input type="number" step="0.01" id="shipping_cost" name="shipping_cost"
                                                class="form-control" value="{{ $purchase->shipping }}" min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-blocks">
                                            <label for="summernote">Note</label>
                                            <textarea id="summernote" name="note" class="form-control">{{ $purchase->note }}</textarea>
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
                                        <span>$<span
                                                id="subtotal-value">{{ number_format($purchase->subtotal, 2) }}</span></span>
                                        <input type="hidden" id="subtotal-input" name="subtotal"
                                            value="{{ $purchase->subtotal }}">
                                    </div>
                                    <div class="purchase-total-item d-flex justify-content-between mb-3">
                                        <span>Tax:</span>
                                        <span>$<span
                                                id="tax-value">{{ number_format($purchase->total_tax, 2) }}</span></span>
                                        <input type="hidden" id="tax-input" name="tax_amount"
                                            value="{{ $purchase->total_tax }}">
                                    </div>
                                    <div class="purchase-total-item d-flex justify-content-between mb-3">
                                        <span>Discount:</span>
                                        <span>$<span
                                                id="discount-value">{{ number_format($purchase->discount, 2) }}</span></span>
                                        <input type="hidden" id="discount-input" value="{{ $purchase->discount }}">
                                    </div>
                                    <div
                                        class="purchase-total-item d-flex justify-content-between mb-3 border-top border-bottom py-2">
                                        <h5>Grand Total:</h5>
                                        <h5>$<span
                                                id="grand-total-value">{{ number_format($purchase->grand_total, 2) }}</span>
                                        </h5>
                                        <input type="hidden" id="grand-total-input" name="grand_total"
                                            value="{{ $purchase->grand_total }}">
                                    </div>
                                    <div class="purchase-total-item d-flex justify-content-between mb-3">
                                        <h6>Paid Amount:</h6>
                                        <div>
                                            <input type="number" step="0.01" id="paid_amount" name="paid_amount"
                                                class="form-control" value="{{ $purchase->paid_amount }}" min="0"
                                                required>
                                        </div>
                                    </div>
                                    <div class="purchase-total-item d-flex justify-content-between mb-3 border-top pt-2">
                                        <h6>Due Amount:</h6>
                                        <h6>$<span
                                                id="due-amount-value">{{ number_format($purchase->due_amount, 2) }}</span>
                                        </h6>
                                        <input type="hidden" id="due_amount" name="due_amount"
                                            value="{{ $purchase->due_amount }}">
                                    </div>
                                    <div class="input-blocks mb-3">
                                        <label for="payment_method">Payment Method</label>
                                        <select class="select" id="payment_method" name="payment_method">
                                            <option value="Cash"
                                                {{ $purchase->payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="Bank Transfer"
                                                {{ $purchase->payment_method == 'Bank Transfer' ? 'selected' : '' }}>Bank
                                                Transfer</option>
                                            <option value="Credit Card"
                                                {{ $purchase->payment_method == 'Credit Card' ? 'selected' : '' }}>Credit
                                                Card</option>
                                            <option value="Cheque"
                                                {{ $purchase->payment_method == 'Cheque' ? 'selected' : '' }}>Cheque
                                            </option>
                                            <option value="Other"
                                                {{ $purchase->payment_method == 'Other' ? 'selected' : '' }}>Other</option>
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
                        <i class="fas fa-save me-2"></i>Update Purchase
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

    <script>
        $(document).ready(function() {
            // Load existing purchase items
            @foreach ($purchase->medicines as $medicine)
                addMedicineRow({
                    id: {{ $medicine->id }},
                    name: "{{ $medicine->name }}",
                    batchNo: "{{ $medicine->pivot->batch_no }}",
                    expiryDate: "{{ $medicine->pivot->expiry_date }}",
                    quantity: {{ $medicine->pivot->quantity }},
                    mrp: {{ $medicine->mrp ?? 0 }},
                    unitPrice: {{ $medicine->pivot->unit_price }},
                    discount: {{ $medicine->pivot->discount }},
                    taxRate: {{ $medicine->tax_rate ?? 0 }},
                    taxAmount: {{ $medicine->pivot->unit_price * $medicine->pivot->quantity * (($medicine->tax_rate ?? 0) / 100) }},
                    subtotal: {{ $medicine->pivot->total_price }},
                    rowTotal: {{ $medicine->pivot->grand_total }}
                });
            @endforeach

            // Calculate initial totals
            calculateTotals();
        });
    </script>
@endpush
