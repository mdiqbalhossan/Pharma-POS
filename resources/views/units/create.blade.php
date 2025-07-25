@extends('layouts.app')

@section('title', __('units.create_unit'))

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('units.create_unit'),
        'subtitle' => __('units.add_new_unit'),
        'button' => [
            'text' => __('units.back_to_units'),
            'url' => route('units.index'),
            'icon' => 'arrow-left',
        ],
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('units.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">{{ __('units.name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">{{ __('units.description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="1">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">{{ __('units.create_unit') }}</button>
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
