@extends('layouts.app')

@section('title', __('Payment Settings'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Payment Settings') }}</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('settings.payment.update') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-3">{{ __('Payment Methods') }}</h5>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="payment_cash_enabled"
                                                name="payment_cash_enabled" value="1"
                                                {{ $settings['payment_cash_enabled'] == '1' ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                for="payment_cash_enabled">{{ __('Enable Cash Payment') }}</label>
                                        </div>
                                        <small class="text-muted">{{ __('Allow customers to pay with cash.') }}</small>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="payment_card_enabled"
                                                name="payment_card_enabled" value="1"
                                                {{ $settings['payment_card_enabled'] == '1' ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                for="payment_card_enabled">{{ __('Enable Card Payment') }}</label>
                                        </div>
                                        <small
                                            class="text-muted">{{ __('Allow customers to pay with credit/debit cards.') }}</small>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="payment_bank_enabled"
                                                name="payment_bank_enabled" value="1"
                                                {{ $settings['payment_bank_enabled'] == '1' ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                for="payment_bank_enabled">{{ __('Enable Bank Transfer') }}</label>
                                        </div>
                                        <small
                                            class="text-muted">{{ __('Allow customers to pay via bank transfer.') }}</small>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="payment_cheque_enabled"
                                                name="payment_cheque_enabled" value="1"
                                                {{ $settings['payment_cheque_enabled'] == '1' ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                for="payment_cheque_enabled">{{ __('Enable Cheque Payment') }}</label>
                                        </div>
                                        <small class="text-muted">{{ __('Allow customers to pay with cheques.') }}</small>
                                    </div>
                                </div>
                            </div>
                            {{-- Inline css is used because dynamically hide/show the bank details section --}}
                            <div class="row mt-3 bank-details-section" id="bank_details_section"
                                style="{{ $settings['payment_bank_enabled'] == '1' ? '' : 'display: none;' }}">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="bank_details">{{ __('Bank Account Details') }}</label>
                                        <textarea name="bank_details" id="bank_details" rows="4"
                                            class="form-control @error('bank_details') is-invalid @enderror">{{ old('bank_details', $settings['bank_details']) }}</textarea>
                                        <small
                                            class="text-muted">{{ __('Enter your bank account details for bank transfers (account number, bank name, etc.)') }}</small>
                                        @error('bank_details')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="payment_other_enabled"
                                                name="payment_other_enabled" value="1"
                                                {{ $settings['payment_other_enabled'] == '1' ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                for="payment_other_enabled">{{ __('Enable Other Payment Method') }}</label>
                                        </div>
                                        <small
                                            class="text-muted">{{ __('Allow an additional custom payment method.') }}</small>
                                    </div>
                                </div>

                                {{-- Inline css is used because dynamically hide/show the other payment method section --}}
                                <div class="col-md-6 other-payment-section" id="other_payment_section"
                                    style="{{ $settings['payment_other_enabled'] == '1' ? '' : 'display: none;' }}">
                                    <div class="form-group mb-3">
                                        <label for="payment_other_label">{{ __('Other Payment Method Label') }}</label>
                                        <input type="text" name="payment_other_label" id="payment_other_label"
                                            class="form-control @error('payment_other_label') is-invalid @enderror"
                                            value="{{ old('payment_other_label', $settings['payment_other_label']) }}">
                                        <small
                                            class="text-muted">{{ __('Label for the other payment method (e.g. Mobile Payment, PayPal, etc.)') }}</small>
                                        @error('payment_other_label')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-end mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ __('Save Payment Settings') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/pages/payment_settings.js') }}"></script>
@endsection
