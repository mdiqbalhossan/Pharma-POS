@extends('layouts.app')

@section('title', __('Store Info'))

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('Create Store'),
        'subtitle' => __('Add New Store'),
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('stores.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h5>Store Info</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="mobile" class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile"
                            name="mobile" value="{{ old('mobile') }}" required>
                        @error('mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <div class="d-flex">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" name="status" id="active" value="active"
                                    {{ old('status') == 'active' ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">
                                    Active
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="inactive"
                                    value="inactive" {{ old('status') == 'inactive' ? 'checked' : '' }}>
                                <label class="form-check-label" for="inactive">
                                    Inactive
                                </label>
                            </div>
                        </div>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="cover_image" class="form-label">Cover Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                            id="cover_image" name="cover_image" required>
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                            required>{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h5 class="mt-4">Store Owner</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="owner_name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('owner_name') is-invalid @enderror" id="owner_name"
                            name="owner_name" value="{{ old('owner_name') }}" required>
                        @error('owner_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="owner_email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('owner_email') is-invalid @enderror"
                            id="owner_email" name="owner_email" value="{{ old('owner_email') }}" required>
                        @error('owner_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('stores.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
@endpush
