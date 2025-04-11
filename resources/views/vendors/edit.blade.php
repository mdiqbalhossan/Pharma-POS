@extends('layouts.app')

@section('title', __('Edit Vendor'))

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('Edit Vendor'),
        'subtitle' => __('Update vendor information'),
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('vendors.update', $vendor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $vendor->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">{{ __('Phone') }}</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone', $vendor->phone) }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $vendor->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">{{ __('Address') }}</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" value="{{ old('address', $vendor->address) }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="city" class="form-label">{{ __('City') }}</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                            name="city" value="{{ old('city', $vendor->city) }}">
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="state" class="form-label">{{ __('State') }}</label>
                        <input type="text" class="form-control @error('state') is-invalid @enderror" id="state"
                            name="state" value="{{ old('state', $vendor->state) }}">
                        @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="zip" class="form-label">{{ __('ZIP Code') }}</label>
                        <input type="text" class="form-control @error('zip') is-invalid @enderror" id="zip"
                            name="zip" value="{{ old('zip', $vendor->zip) }}">
                        @error('zip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="opening_balance" class="form-label">{{ __('Opening Balance') }}</label>
                        <input type="number" step="0.01"
                            class="form-control @error('opening_balance') is-invalid @enderror" id="opening_balance"
                            name="opening_balance" value="{{ old('opening_balance', $vendor->opening_balance) }}">
                        @error('opening_balance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="opening_balance_type" class="form-label">{{ __('Balance Type') }}</label>
                        <select class="form-select @error('opening_balance_type') is-invalid @enderror"
                            id="opening_balance_type" name="opening_balance_type">
                            <option value="debit"
                                {{ old('opening_balance_type', $vendor->opening_balance_type) == 'debit' ? 'selected' : '' }}>
                                {{ __('Debit') }}</option>
                            <option value="credit"
                                {{ old('opening_balance_type', $vendor->opening_balance_type) == 'credit' ? 'selected' : '' }}>
                                {{ __('Credit') }}</option>
                        </select>
                        @error('opening_balance_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">{{ __('Update Vendor') }}</button>
                        <a href="{{ route('vendors.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
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
