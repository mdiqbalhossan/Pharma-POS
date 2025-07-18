@extends('layouts.app')

@section('title', __('expense_category.create_expense_category'))

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('expense_category.create_expense_category'),
        'subtitle' => __('expense_category.add_new_expense_category'),
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('expense-categories.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ __('expense_category.name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="description" class="form-label">{{ __('expense_category.description') }}</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">{{ __('expense_category.create') }}</button>
                        <a href="{{ route('expense-categories.index') }}"
                            class="btn btn-secondary">{{ __('expense_category.cancel') }}</a>
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
