@extends('layouts.app')

@section('title', 'Create Purchase Return')

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endpush

@section('content')
    <div class="page-header transfer">
        <div class="page-title">
            <h4>Create Purchase Return</h4>
            <h6>Return medicines from purchase #{{ $purchase->invoice_no }}</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-info">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-inner">
                                        <h6>Purchase Information:</h6>
                                        <p><strong>Invoice:</strong> {{ $purchase->invoice_no }}</p>
                                        <p><strong>Supplier:</strong>
                                            {{ $purchase->supplier ? $purchase->supplier->name : 'N/A' }}</p>
                                        <p><strong>Date:</strong>
                                            {{ \Carbon\Carbon::parse($purchase->date)->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-inner">
                                        <h6>Return Information:</h6>
                                        <p><strong>Date:</strong> {{ now()->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="form-title">Select Medicine to Return</div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Medicine</th>
                                    <th>Purchased Qty</th>
                                    <th>Current Stock</th>
                                    <th>Unit Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchase->medicines as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->pivot->quantity }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->pivot->unit_price, 2) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary return-btn"
                                                data-medicine-id="{{ $item->id }}"
                                                data-medicine-name="{{ $item->name }}"
                                                data-purchase-qty="{{ $item->pivot->quantity }}"
                                                data-current-stock="{{ $item->quantity }}"
                                                data-unit-price="{{ $item->pivot->unit_price }}">
                                                Return
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="return-form-container" style="display: none;" class="mt-4">
                <form id="return-form" action="{{ route('purchase-returns.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                    <input type="hidden" id="medicine_id" name="medicine_id">
                    <input type="hidden" id="unit_price" name="unit_price">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-title">Return Details</div>
                        </div>

                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>Medicine</label>
                                <input type="text" id="medicine_name" readonly>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>Purchased Quantity</label>
                                <input type="text" id="purchase_qty" readonly>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>Current Stock</label>
                                <input type="text" id="current_stock" readonly>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>Return Quantity <span class="text-danger">*</span></label>
                                <input type="number" id="quantity" name="quantity" required min="1" step="1"
                                    class="form-control">
                                @error('quantity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>Unit Price <span class="text-danger">*</span></label>
                                <input type="number" id="display_unit_price" readonly class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>Total Price <span class="text-danger">*</span></label>
                                <input type="number" id="total_price" name="total_price" readonly class="form-control">
                                @error('total_price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>Discount (%)</label>
                                <input type="number" id="discount" name="discount" value="0" min="0"
                                    step="0.01" class="form-control">
                                @error('discount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>Tax (%)</label>
                                <input type="number" id="tax" name="tax" value="0" min="0"
                                    step="0.01" class="form-control">
                                @error('tax')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>Grand Total <span class="text-danger">*</span></label>
                                <input type="number" id="grand_total" name="grand_total" readonly class="form-control">
                                @error('grand_total')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>Payment Method <span class="text-danger">*</span></label>
                                <select name="payment_method" required class="select">
                                    <option value="">Select Payment Method</option>
                                    <option value="cash">Cash</option>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                                @error('payment_method')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>Paid Amount <span class="text-danger">*</span></label>
                                <input type="number" id="paid_amount" name="paid_amount" value="0" min="0"
                                    step="0.01" required class="form-control">
                                @error('paid_amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>Due Amount</label>
                                <input type="number" id="due_amount" name="due_amount" readonly class="form-control">
                                @error('due_amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="input-blocks">
                                <label>Note</label>
                                <textarea name="note" rows="3" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-3">
                            <div class="input-blocks">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="confirmation"
                                        id="confirmation" value="1" required>
                                    <label class="form-check-label" for="confirmation">
                                        <strong>You cannot edit purchase return. Confirm you want to return this
                                            medicine.</strong>
                                    </label>
                                </div>
                                @error('confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12 mt-3">
                            <button type="submit" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('purchases.index') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Datetimepicker JS -->
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.return-btn').on('click', function() {
                const medicineId = $(this).data('medicine-id');
                const medicineName = $(this).data('medicine-name');
                const purchaseQty = $(this).data('purchase-qty');
                const currentStock = $(this).data('current-stock');
                const unitPrice = $(this).data('unit-price');

                $('#medicine_id').val(medicineId);
                $('#medicine_name').val(medicineName);
                $('#purchase_qty').val(purchaseQty);
                $('#current_stock').val(currentStock);
                $('#unit_price').val(unitPrice);
                $('#display_unit_price').val(unitPrice);

                $('#return-form-container').show();

                // Set max on quantity
                const maxQty = Math.min(purchaseQty, currentStock);
                $('#quantity').attr('max', maxQty);
            });

            // Calculate totals
            $('#quantity, #discount, #tax, #paid_amount').on('input', function() {
                calculateTotals();
            });

            function calculateTotals() {
                const quantity = parseFloat($('#quantity').val()) || 0;
                const unitPrice = parseFloat($('#unit_price').val()) || 0;
                const discount = parseFloat($('#discount').val()) || 0;
                const tax = parseFloat($('#tax').val()) || 0;
                const paidAmount = parseFloat($('#paid_amount').val()) || 0;

                // Calculate total price
                const totalPrice = quantity * unitPrice;
                $('#total_price').val(totalPrice.toFixed(2));

                // Calculate discount amount
                const discountAmount = totalPrice * (discount / 100);

                // Calculate subtotal
                const subtotal = totalPrice - discountAmount;

                // Calculate tax amount
                const taxAmount = subtotal * (tax / 100);

                // Calculate grand total
                const grandTotal = subtotal + taxAmount;
                $('#grand_total').val(grandTotal.toFixed(2));

                // Calculate due amount
                const dueAmount = grandTotal - paidAmount;
                $('#due_amount').val(dueAmount.toFixed(2));
            }

            // Form validation
            $('#return-form').on('submit', function(e) {
                const quantity = parseInt($('#quantity').val()) || 0;
                const purchaseQty = parseInt($('#purchase_qty').val()) || 0;
                const currentStock = parseInt($('#current_stock').val()) || 0;

                if (quantity <= 0) {
                    alert('Return quantity must be greater than 0');
                    e.preventDefault();
                    return false;
                }

                if (quantity > purchaseQty) {
                    alert('Return quantity cannot be greater than purchased quantity');
                    e.preventDefault();
                    return false;
                }

                if (quantity > currentStock) {
                    alert('Return quantity cannot be greater than current stock');
                    e.preventDefault();
                    return false;
                }

                if (!$('#confirmation').is(':checked')) {
                    alert('Please confirm the return by checking the confirmation box');
                    e.preventDefault();
                    return false;
                }

                return true;
            });
        });
    </script>
@endpush
