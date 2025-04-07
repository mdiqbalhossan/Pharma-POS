@extends('layouts.app')

@section('title', __('medicine_types.edit_title'))

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('medicine_types.edit_title'),
        'subtitle' => __('medicine_types.edit_subtitle'),
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('medicine-types.update', $medicineType->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ __('medicine_types.name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $medicineType->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="description" class="form-label">{{ __('medicine_types.description') }}</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="3">{{ old('description', $medicineType->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">{{ __('medicine_types.update_button') }}</button>
                        <a href="{{ route('medicine-types.index') }}"
                            class="btn btn-secondary">{{ __('medicine_types.cancel') }}</a>
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
