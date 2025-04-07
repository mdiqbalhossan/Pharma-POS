@extends('layouts.app')

@section('title', __('customers.customer_details'))

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('customers.customer_details'),
        'subtitle' => __('customers.view_customer_info'),
        'button' => [
            'text' => __('customers.edit'),
            'url' => route('customers.edit', $customer->id),
            'icon' => 'edit',
        ],
    ])

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ __('customers.customer_info') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('customers.name') }}</label>
                                <p>{{ $customer->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('customers.phone') }}</label>
                                <p>{{ $customer->phone }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('customers.email') }}</label>
                                <p>{{ $customer->email ?? __('customers.n_a') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('customers.address') }}</label>
                                <p>
                                    {{ $customer->address ?? __('customers.n_a') }}
                                    @if ($customer->city || $customer->state || $customer->zip)
                                        <br>
                                        {{ collect([$customer->city, $customer->state, $customer->zip])->filter()->implode(', ') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('customers.opening_balance') }}</label>
                                <p>
                                    @if ($customer->opening_balance)
                                        <span
                                            class="badge bg-{{ $customer->opening_balance_type === 'credit' ? 'success' : 'danger' }}">
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
                                <label class="form-label fw-bold">{{ __('customers.created_on') }}</label>
                                <p>{{ $customer->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">{{ __('customers.back') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
