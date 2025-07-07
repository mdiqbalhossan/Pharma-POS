@extends('layouts.app')

@section('title', __('medicine_leafs.create_medicine_leaf'))

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('medicine_leafs.create_medicine_leaf'),
        'subtitle' => __('medicine_leafs.add_new'),
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('medicine-leafs.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">{{ __('medicine_leafs.type') }}</label>
                        <input type="text" class="form-control @error('type') is-invalid @enderror" id="type"
                            name="type" value="{{ old('type') }}" required>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="qty_box" class="form-label">{{ __('medicine_leafs.quantity_per_box') }}</label>
                        <input type="number" class="form-control @error('qty_box') is-invalid @enderror" id="qty_box"
                            name="qty_box" value="{{ old('qty_box') }}" required>
                        @error('qty_box')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <button type="submit"
                            class="btn btn-primary">{{ __('medicine_leafs.create_medicine_leaf') }}</button>
                        <a href="{{ route('medicine-leafs.index') }}"
                            class="btn btn-secondary">{{ __('medicine_leafs.cancel') }}</a>
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
