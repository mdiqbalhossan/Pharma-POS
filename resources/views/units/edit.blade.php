@extends('layouts.app')

@section('title', 'Edit Unit')

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'Edit Unit',
        'subtitle' => 'Update unit information',
        'button' => [
            'text' => 'Back to Units',
            'url' => route('units.index'),
            'icon' => 'arrow-left',
        ],
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('units.update', $unit->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $unit->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="1">{{ old('description', $unit->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Update Unit</button>
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
