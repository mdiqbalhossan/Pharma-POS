@extends('layouts.app')

@section('title', 'Edit Medicine Leaf')

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'Edit Medicine Leaf',
        'subtitle' => 'Update medicine leaf details',
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('medicine-leafs.update', $medicineLeaf->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" class="form-control @error('type') is-invalid @enderror" id="type"
                            name="type" value="{{ old('type', $medicineLeaf->type) }}" required>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="qty_box" class="form-label">Quantity per Box</label>
                        <input type="number" class="form-control @error('qty_box') is-invalid @enderror" id="qty_box"
                            name="qty_box" value="{{ old('qty_box', $medicineLeaf->qty_box) }}" required>
                        @error('qty_box')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Update Medicine Leaf</button>
                        <a href="{{ route('medicine-leafs.index') }}" class="btn btn-secondary">Cancel</a>
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