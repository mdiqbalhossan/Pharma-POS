@extends('layouts.app')

@section('title', 'Vendor Details')

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'Vendor Details',
        'subtitle' => 'View vendor information',
        'button' => [
            'text' => 'Edit Vendor',
            'url' => route('vendors.edit', $vendor->id),
            'icon' => 'edit'
        ]
    ])

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Name</h6>
                            <p class="mb-0">{{ $vendor->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Phone</h6>
                            <p class="mb-0">{{ $vendor->phone }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Email</h6>
                            <p class="mb-0">{{ $vendor->email ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Created On</h6>
                            <p class="mb-0">{{ $vendor->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Financial Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted">Opening Balance</h6>
                        @if($vendor->opening_balance)
                            <p class="badge bg-{{ $vendor->opening_balance_type === 'credit' ? 'success' : 'danger' }} fs-6">
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
                    <h5 class="card-title">Address Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h6 class="text-muted">Address</h6>
                            <p class="mb-0">{{ $vendor->address ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="text-muted">City</h6>
                            <p class="mb-0">{{ $vendor->city ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="text-muted">State</h6>
                            <p class="mb-0">{{ $vendor->state ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="text-muted">ZIP Code</h6>
                            <p class="mb-0">{{ $vendor->zip ?: 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Back to List</a>
        <a href="{{ route('vendors.edit', $vendor->id) }}" class="btn btn-primary">Edit Vendor</a>
    </div>
@endsection 