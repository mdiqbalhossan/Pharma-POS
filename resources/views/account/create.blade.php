@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'Create Account',
        'subtitle' => 'Add a new account',
        'button' => [
            'text' => 'Back',
            'url' => route('accounts.index'),
            'icon' => 'arrow-left',
        ],
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('accounts.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Account Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Account Type <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="select @error('type') is-invalid @enderror" required>
                            <option value="">Select Type</option>
                            <option value="asset" {{ old('type') == 'asset' ? 'selected' : '' }}>Asset</option>
                            <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Income</option>
                            <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                            <option value="equity" {{ old('type') == 'equity' ? 'selected' : '' }}>Equity</option>
                            <option value="liability" {{ old('type') == 'liability' ? 'selected' : '' }}>Liability</option>
                            <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                        rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active"
                            class="form-check-input @error('is_active') is-invalid @enderror" value="1"
                            {{ old('is_active') ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Active</label>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save Account</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
@endpush
