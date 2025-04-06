@extends('layouts.app')

@section('title', 'Edit Expense')

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'Edit Expense',
        'subtitle' => 'Update expense details',
        'button' => [
            'text' => 'Back',
            'url' => route('expenses.index'),
            'icon' => 'arrow-left'
        ]
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="expense_category_id" class="form-label">Expense Category <span class="text-danger">*</span></label>
                        <select name="expense_category_id" id="expense_category_id" class="select @error('expense_category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($expenseCategories as $category)
                                <option value="{{ $category->id }}" {{ (old('expense_category_id', $expense->expense_category_id) == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('expense_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                        <div class="input-blocks date-group mt-0">
                            <i data-feather="calendar" class="info-img"></i>
                            <div class="input-groupicon">
                                <input type="text" name="date" id="date" class="datetimepicker @error('date') is-invalid @enderror" placeholder="Choose Date" value="{{ old('date', $expense->date ? $expense->date->format('Y-m-d') : '') }}" required>
                            </div>
                        </div>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="expense_for" class="form-label">Expense For <span class="text-danger">*</span></label>
                        <input type="text" name="expense_for" id="expense_for" class="form-control @error('expense_for') is-invalid @enderror" value="{{ old('expense_for', $expense->expense_for) }}" required>
                        @error('expense_for')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                        <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', $expense->amount) }}" min="0" step="0.01" required>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="reference" class="form-label">Reference</label>
                        <input type="text" name="reference" id="reference" class="form-control @error('reference') is-invalid @enderror" value="{{ old('reference', $expense->reference) }}">
                        @error('reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $expense->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Expense</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
<!-- Datetimepicker JS -->
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- Select2 JS -->
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
@endpush 