@extends('layouts.app')

@section('title', __('index.Create Sale Return'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endpush

@section('content')
    <div class="page-header transfer">
        <div class="page-title">
            <h4>{{ __('index.Create Sale Return') }}</h4>
            <h6>{{ __('index.Return medicines from sale') }} #{{ $sale->sale_no }}</h6>
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
                                        <h6>{{ __('index.Sale Information:') }}</h6>
                                        <p><strong>{{ __('index.Invoice:') }}</strong> #{{ $sale->sale_no }}</p>
                                        <p><strong>{{ __('index.Customer:') }}</strong>
                                            {{ $sale->customer ? $sale->customer->name : __('index.N/A') }}</p>
                                        <p><strong>{{ __('index.Date:') }}</strong>
                                            {{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-inner">
                                        <h6>{{ __('index.Return Information:') }}</h6>
                                        <p><strong>{{ __('index.Date:') }}</strong> {{ now()->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="form-title">{{ __('index.Select Medicine to Return') }}</div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('index.Medicine') }}</th>
                                    <th>{{ __('index.Sold Qty') }}</th>
                                    <th>{{ __('index.Unit Price') }}</th>
                                    <th>{{ __('index.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sale->medicines as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->pivot->quantity }} {{ $item->unit->name }}</td>
                                        <td>{{ show_amount($item->pivot->price) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary return-btn"
                                                data-medicine-id="{{ $item->id }}"
                                                data-medicine-name="{{ $item->name }}"
                                                data-sold-qty="{{ $item->pivot->quantity }}"
                                                data-unit-price="{{ $item->pivot->price }}">
                                                {{ __('index.Return') }}
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
                            <div class="form-title">{{ __('index.Return Details') }}</div>
                        </div>

                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>{{ __('index.Medicine') }}</label>
                                <input type="text" id="medicine_name" readonly>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>{{ __('index.Sold Quantity') }}</label>
                                <input type="text" id="sold_qty" readonly>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>{{ __('index.Return Quantity') }} <span class="text-danger">*</span></label>
                                <input type="number" id="quantity" name="quantity" required min="1" step="1"
                                    class="form-control">
                                @error('quantity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>{{ __('index.Unit Price') }} <span class="text-danger">*</span></label>
                                <input type="number" id="display_unit_price" readonly class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>{{ __('index.Total Price') }} <span class="text-danger">*</span></label>
                                <input type="number" id="total_price" name="total_price" readonly class="form-control">
                                @error('total_price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>{{ __('index.Discount') }} (%)</label>
                                <input type="number" id="discount" name="discount" value="0" min="0"
                                    step="0.01" class="form-control">
                                @error('discount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>{{ __('index.Tax') }} (%)</label>
                                <input type="number" id="tax" name="tax" value="0" min="0"
                                    step="0.01" class="form-control">
                                @error('tax')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>{{ __('index.Grand Total') }} <span class="text-danger">*</span></label>
                                <input type="number" id="grand_total" name="grand_total" readonly class="form-control">
                                @error('grand_total')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>{{ __('index.Payment Method') }} <span class="text-danger">*</span></label>
                                <select name="payment_method" required class="select">
                                    <option value="">{{ __('index.Select Payment Method') }}</option>
                                    <option value="cash">{{ __('index.Cash') }}</option>
                                    <option value="credit_card">{{ __('index.Credit Card') }}</option>
                                    <option value="bank_transfer">{{ __('index.Bank Transfer') }}</option>
                                    <option value="cheque">{{ __('index.Cheque') }}</option>
                                </select>
                                @error('payment_method')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>{{ __('index.Account') }} <span class="text-danger">*</span></label>
                                <select name="account_id" id="account_id" class="form-control select2" required>
                                    <option value="">{{ __('index.Select Account') }}</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                                @error('account_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>{{ __('index.Paid Amount') }} <span class="text-danger">*</span></label>
                                <input type="number" id="paid_amount" name="paid_amount" value="0" min="0"
                                    step="0.01" required class="form-control">
                                @error('paid_amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="input-blocks">
                                <label>{{ __('index.Due Amount') }}</label>
                                <input type="number" id="due_amount" name="due_amount" readonly class="form-control">
                                @error('due_amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="input-blocks">
                                <label>{{ __('index.Note') }}</label>
                                <textarea name="note" rows="3" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-3">
                            <div class="input-blocks">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="confirmation"
                                        id="confirmation" value="1" required>
                                    <label class="form-check-label" for="confirmation">
                                        <strong>{{ __('index.You cannot edit sale return. Confirm you want to return this medicine.') }}</strong>
                                    </label>
                                </div>
                                @error('confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12 mt-3">
                            <button type="submit" class="btn btn-submit me-2">{{ __('index.Submit') }}</button>
                            <a href="{{ route('sales.index') }}" class="btn btn-cancel">{{ __('index.Cancel') }}</a>
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
