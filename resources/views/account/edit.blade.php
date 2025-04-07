@extends('layouts.app')

@section('title', __('account.edit_account'))

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('account.edit_account'),
        'subtitle' => __('account.manage_your_accounts'),
        'button' => [
            'text' => __('account.back'),
            'url' => route('accounts.index'),
            'icon' => 'arrow-left',
        ],
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('accounts.update', $account->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ __('account.account_name') }} <span
                                class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $account->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">{{ __('account.account_type') }} <span
                                class="text-danger">*</span></label>
                        <select name="type" id="type" class="select @error('type') is-invalid @enderror" required>
                            <option value="">{{ __('account.select_type') }}</option>
                            <option value="asset" {{ old('type', $account->type) == 'asset' ? 'selected' : '' }}>
                                {{ __('account.assets') }}
                            </option>
                            <option value="income" {{ old('type', $account->type) == 'income' ? 'selected' : '' }}>
                                {{ __('account.revenue') }}
                            </option>
                            <option value="expense" {{ old('type', $account->type) == 'expense' ? 'selected' : '' }}>
                                {{ __('account.expense') }}
                            </option>
                            <option value="equity" {{ old('type', $account->type) == 'equity' ? 'selected' : '' }}>
                                {{ __('account.equity') }}
                            </option>
                            <option value="liability" {{ old('type', $account->type) == 'liability' ? 'selected' : '' }}>
                                {{ __('account.liabilities') }}</option>
                            <option value="other" {{ old('type', $account->type) == 'other' ? 'selected' : '' }}>
                                {{ __('account.other') }}
                            </option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('account.description') }}</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                        rows="4">{{ old('description', $account->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active"
                            class="form-check-input @error('is_active') is-invalid @enderror" value="1"
                            {{ old('is_active', $account->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">{{ __('account.is_active') }}</label>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">{{ __('account.update') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
@endpush
