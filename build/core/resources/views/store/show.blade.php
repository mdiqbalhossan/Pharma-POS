@extends('layouts.app')

@section('title', __('Store Details'))

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('Store Details'),
        'subtitle' => __('View Store Information'),
        'button' => [
            'text' => __('Edit'),
            'url' => route('stores.edit', $store->id),
            'icon' => 'edit',
        ],
    ])

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Store Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            @if ($store->cover_image)
                                <img src="{{ photo_url($store->cover_image) }}" alt="Cover Image" class="img-fluid rounded"
                                    style="max-height: 200px;">
                            @else
                                <div class="border p-3 text-center rounded">
                                    <i data-feather="image" class="feather-image"
                                        style="width: 100px; height: 100px; color: #ccc;"></i>
                                    <p class="mt-2">No image available</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Name</label>
                                        <p>{{ $store->name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Email</label>
                                        <p>{{ $store->email }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Phone</label>
                                        <p>{{ $store->phone }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status</label>
                                        <p>
                                            <span class="badge bg-{{ $store->status === 'active' ? 'success' : 'danger' }}">
                                                {{ ucfirst($store->status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Address</label>
                                        <p>{{ $store->address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5 class="mb-3">Store Owner Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Name</label>
                                    <p>{{ $store->user->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <p>{{ $store->user->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Created On</label>
                                    <p>{{ $store->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('stores.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
