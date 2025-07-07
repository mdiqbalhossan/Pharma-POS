@extends('layouts.app')

@section('title', __('Vendor Details'))

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('Vendor Details'),
        'subtitle' => __('View vendor information'),
        'button' => [
            'text' => __('Edit Vendor'),
            'url' => route('vendors.edit', $vendor->id),
            'icon' => 'edit',
        ],
    ])

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Basic Information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">{{ __('Name') }}</h6>
                            <p class="mb-0">{{ $vendor->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">{{ __('Phone') }}</h6>
                            <p class="mb-0">{{ $vendor->phone }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">{{ __('Email') }}</h6>
                            <p class="mb-0">{{ $vendor->email ?: __('N/A') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">{{ __('Created On') }}</h6>
                            <p class="mb-0">{{ $vendor->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Financial Information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted">{{ __('Opening Balance') }}</h6>
                        @if ($vendor->opening_balance)
                            <p
                                class="badge bg-{{ $vendor->opening_balance_type === 'credit' ? 'success' : 'danger' }} fs-6">
                                {{ $vendor->formatted_opening_balance }}
                                ({{ ucfirst($vendor->opening_balance_type) }})
                            </p>
                        @else
                            <p class="badge bg-secondary fs-6">0.00</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Address Information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h6 class="text-muted">{{ __('Address') }}</h6>
                            <p class="mb-0">{{ $vendor->address ?: __('N/A') }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="text-muted">{{ __('City') }}</h6>
                            <p class="mb-0">{{ $vendor->city ?: __('N/A') }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="text-muted">{{ __('State') }}</h6>
                            <p class="mb-0">{{ $vendor->state ?: __('N/A') }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="text-muted">{{ __('ZIP Code') }}</h6>
                            <p class="mb-0">{{ $vendor->zip ?: __('N/A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <a href="{{ route('vendors.index') }}" class="btn btn-secondary">{{ __('Back to List') }}</a>
        <a href="{{ route('vendors.edit', $vendor->id) }}" class="btn btn-primary">{{ __('Edit Vendor') }}</a>
    </div>
@endsection
