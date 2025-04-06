@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'Customer Details',
        'subtitle' => 'View customer information',
        'button' => [
            'text' => 'Edit Customer',
            'url' => route('customers.edit', $customer->id),
            'icon' => 'edit'
        ]
    ])

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <p>{{ $customer->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Phone</label>
                                <p>{{ $customer->phone }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <p>{{ $customer->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Address</label>
                                <p>
                                    {{ $customer->address ?? 'N/A' }}
                                    @if($customer->city || $customer->state || $customer->zip)
                                        <br>
                                        {{ collect([$customer->city, $customer->state, $customer->zip])->filter()->implode(', ') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Opening Balance</label>
                                <p>
                                    @if($customer->opening_balance)
                                        <span class="badge bg-{{ $customer->opening_balance_type === 'credit' ? 'success' : 'danger' }}">
                                            {{ $customer->formatted_opening_balance }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">0.00</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Created On</label>
                                <p>{{ $customer->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back to Customers</a>
                </div>
            </div>
        </div>
    </div>
@endsection 