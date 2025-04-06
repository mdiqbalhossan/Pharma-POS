@extends('layouts.app')

@section('title', 'Create Sale Return')

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endpush

@section('content')
    <div class="page-header transfer">
        <div class="page-title">
            <h4>Create Sale Return</h4>
            <h6>Return medicines from sale #{{ $sale->sale_no }}</h6>
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
                                        <h6>Sale Information:</h6>
                                        <p><strong>Invoice:</strong> #{{ $sale->sale_no }}</p>
                                        <p><strong>Customer:</strong>
                                            {{ $sale->customer ? $sale->customer->name : 'N/A' }}</p>
                                        <p><strong>Date:</strong>
                                            {{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y') }}</p>
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
                                    <th>Sold Qty</th>
                                    <th>Unit Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sale->medicines as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->pivot->quantity }}</td>
                                        <td>{{ number_format($item->pivot->price, 2) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary return-btn"
                                                data-medicine-id="{{ $item->id }}"
                                                data-medicine-name="{{ $item->name }}"
                                                data-sold-qty="{{ $item->pivot->quantity }}"
                                                data-unit-price="{{ $item->pivot->price }}">
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
                <form id="return-form" action="{{ route('sale-returns.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="sale_id" value="{{ $sale->id }}">
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
                                <label>Sold Quantity</label>
                                <input type="text" id="sold_qty" readonly>
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
                                        <strong>You cannot edit sale return. Confirm you want to return this
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
                            <a href="{{ route('sales.index') }}" class="btn btn-cancel">Cancel</a>
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

    <script src="{{ asset('assets/js/pages/sale_return.js') }}"></script>
@endpush
