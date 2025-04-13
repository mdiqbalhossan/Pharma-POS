@extends('layouts.app')

@section('title', __('customers.create_customer'))

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('customers.create_customer'),
        'subtitle' => __('customers.add_new_customer'),
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ __('customers.name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="number" class="form-label">{{ __('customers.phone') }}</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="number"
                            name="phone" value="{{ old('phone') }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">{{ __('customers.email') }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">{{ __('customers.address') }}</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" value="{{ old('address') }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="city" class="form-label">{{ __('customers.city') }}</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                            name="city" value="{{ old('city') }}">
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="state" class="form-label">{{ __('customers.state') }}</label>
                        <input type="text" class="form-control @error('state') is-invalid @enderror" id="state"
                            name="state" value="{{ old('state') }}">
                        @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="zip" class="form-label">{{ __('customers.zip') }}</label>
                        <input type="text" class="form-control @error('zip') is-invalid @enderror" id="zip"
                            name="zip" value="{{ old('zip') }}">
                        @error('zip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="opening_balance" class="form-label">{{ __('customers.opening_balance') }}</label>
                        <input type="number" step="0.01"
                            class="form-control @error('opening_balance') is-invalid @enderror" id="opening_balance"
                            name="opening_balance" value="{{ old('opening_balance') }}">
                        @error('opening_balance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="opening_balance_type" class="form-label">{{ __('customers.balance_type') }}</label>
                        <select class="form-select @error('opening_balance_type') is-invalid @enderror"
                            id="opening_balance_type" name="opening_balance_type">
                            <option value="debit" {{ old('opening_balance_type') == 'debit' ? 'selected' : '' }}>
                                {{ __('customers.debit') }}</option>
                            <option value="credit" {{ old('opening_balance_type') == 'credit' ? 'selected' : '' }}>
                                {{ __('customers.credit') }}</option>
                        </select>
                        @error('opening_balance_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">{{ __('customers.create') }}</button>
                        <a href="{{ route('customers.index') }}"
                            class="btn btn-secondary">{{ __('customers.cancel') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
@endpush
