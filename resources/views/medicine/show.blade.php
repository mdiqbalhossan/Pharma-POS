@extends('layouts.app')

@section('title', __('medicine.medicine_details'))

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('medicine.medicine_details'),
        'subtitle' => __('medicine.view_medicine_information'),
    ])

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title mb-0">{{ $medicine->name }}</h4>
                        @if ($medicine->is_active)
                            <span class="badge bg-success ms-2">{{ __('medicine.active') }}</span>
                        @else
                            <span class="badge bg-danger ms-2">{{ __('medicine.inactive') }}</span>
                        @endif
                        @if ($medicine->prescription_required)
                            <span class="badge bg-warning ms-2">{{ __('medicine.prescription_required') }}</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Left column with image and basic info -->
                        <div class="col-md-3 text-center mb-4">
                            @if ($medicine->image)
                                <img src="{{ asset($medicine->image) }}" alt="{{ $medicine->name }}"
                                    class="img-fluid rounded mb-3 he-200p-max">
                            @else
                                <div class="border rounded d-flex align-items-center justify-content-center he-200p">
                                    <i data-feather="image" class="feather-no-placeholder"></i>
                                </div>
                            @endif

                            <div class="d-grid gap-2 mt-3">
                                <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-primary">
                                    <i data-feather="edit" class="feather-sm me-1"></i> {{ __('medicine.edit') }}
                                </a>
                                <button type="button" class="btn btn-danger confirm-text" data-id="{{ $medicine->id }}">
                                    <i data-feather="trash-2" class="feather-sm me-1"></i> {{ __('medicine.delete') }}
                                </button>
                                <form id="delete-form-{{ $medicine->id }}"
                                    action="{{ route('medicines.destroy', $medicine->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>

                        <!-- Right column with detailed info -->
                        <div class="col-md-9">
                            <div class="row">
                                <!-- Basic Information Section -->
                                <div class="col-12 mb-4">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0"><i data-feather="info" class="feather-sm me-1"></i>
                                                {{ __('medicine.basic_information') }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.name') }}</h6>
                                                    <p class="text-dark">{{ $medicine->name }}</p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.generic_name') }}</h6>
                                                    <p class="text-dark">{{ $medicine->generic_name ?: __('medicine.na') }}
                                                    </p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.barcode') }}</h6>
                                                    <p class="text-dark">{{ $medicine->barcode ?: __('medicine.na') }}</p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.medicine_type') }}</h6>
                                                    <p class="text-dark">
                                                        {{ $medicine->medicine_type->name ?? __('medicine.na') }}</p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.medicine_leaf') }}</h6>
                                                    <p class="text-dark">
                                                        {{ $medicine->medicine_leaf ? $medicine->medicine_leaf->type . ' (' . $medicine->medicine_leaf->qty_box . ')' : __('medicine.na') }}
                                                    </p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.unit') }}</h6>
                                                    <p class="text-dark">{{ $medicine->unit->name ?? __('medicine.na') }}
                                                    </p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.batch_number') }}</h6>
                                                    <p class="text-dark">{{ $medicine->batch_number ?: __('medicine.na') }}
                                                    </p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.dosage') }}</h6>
                                                    <p class="text-dark">{{ $medicine->dosage ?: __('medicine.na') }}</p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.storage_condition') }}</h6>
                                                    <p class="text-dark">
                                                        {{ $medicine->storage_condition ?: __('medicine.na') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pricing Section -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0"><i data-feather="dollar-sign" class="feather-sm me-1"></i>
                                                {{ __('medicine.pricing') }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.sale_price') }}</h6>
                                                    <p class="text-dark fw-bold">
                                                        {{ number_format($medicine->sale_price, 2) }}</p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.purchase_price') }}</h6>
                                                    <p class="text-dark">{{ number_format($medicine->purchase_price, 2) }}
                                                    </p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.vat') }} (%)</h6>
                                                    <p class="text-dark">{{ $medicine->vat_percentage ?: '0' }}%</p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.discount') }} (%)</h6>
                                                    <p class="text-dark">{{ $medicine->discount_percentage ?: '0' }}%</p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.loyalty_point') }}</h6>
                                                    <p class="text-dark">{{ $medicine->loyalty_point ?: '0' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Inventory Section -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0"><i data-feather="package" class="feather-sm me-1"></i>
                                                {{ __('medicine.inventory') }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.quantity') }}</h6>
                                                    <p class="text-dark">{{ $medicine->quantity ?: '0' }}</p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.reorder_level') }}</h6>
                                                    <p class="text-dark">
                                                        {{ $medicine->reorder_level ?: __('medicine.na') }}</p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.alert_quantity') }}</h6>
                                                    <p class="text-dark">
                                                        {{ $medicine->alert_quantity ?: __('medicine.na') }}</p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.shelf') }}</h6>
                                                    <p class="text-dark">{{ $medicine->shelf ?: __('medicine.na') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Supplier/Vendor Section -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0"><i data-feather="truck" class="feather-sm me-1"></i>
                                                {{ __('medicine.supplier_vendor') }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">Supplier</h6>
                                                    <p class="text-dark">
                                                        {{ $medicine->supplier->name ?? __('medicine.na') }}</p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">Vendor</h6>
                                                    <p class="text-dark">
                                                        {{ $medicine->vendor->name ?? __('medicine.na') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dates Section -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0"><i data-feather="calendar" class="feather-sm me-1"></i>
                                                {{ __('medicine.dates') }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.manufacturing_date') }}
                                                    </h6>
                                                    <p class="text-dark">
                                                        {{ $medicine->manufacturing_date ? date('M d, Y', strtotime($medicine->manufacturing_date)) : __('medicine.na') }}
                                                    </p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.expiration_date') }}</h6>
                                                    <p class="text-dark">
                                                        @if ($medicine->expiration_date)
                                                            {{ date('M d, Y', strtotime($medicine->expiration_date)) }}
                                                            @php
                                                                $now = new DateTime();
                                                                $expiry = new DateTime($medicine->expiration_date);
                                                                $diff = $now->diff($expiry);
                                                            @endphp
                                                            @if ($now > $expiry)
                                                                <span
                                                                    class="badge bg-danger">{{ __('medicine.expired') }}</span>
                                                            @elseif($diff->days < 30)
                                                                <span
                                                                    class="badge bg-warning">{{ __('medicine.expiring_soon') }}</span>
                                                            @endif
                                                        @else
                                                            {{ __('medicine.na') }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Details -->
                                <div class="col-12 mb-4">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0"><i data-feather="clipboard" class="feather-sm me-1"></i>
                                                {{ __('medicine.additional_information') }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @if ($medicine->description)
                                                    <div class="col-md-12 mb-3">
                                                        <h6 class="text-muted mb-1">{{ __('medicine.description') }}</h6>
                                                        <p class="text-dark">{{ $medicine->description }}</p>
                                                    </div>
                                                @endif

                                                @if ($medicine->side_effects)
                                                    <div class="col-md-12 mb-3">
                                                        <h6 class="text-muted mb-1">{{ __('medicine.side_effects') }}</h6>
                                                        <p class="text-dark">{{ $medicine->side_effects }}</p>
                                                    </div>
                                                @endif

                                                @if ($medicine->contraindications)
                                                    <div class="col-md-12 mb-3">
                                                        <h6 class="text-muted mb-1">{{ __('medicine.contraindications') }}
                                                        </h6>
                                                        <p class="text-dark">{{ $medicine->contraindications }}</p>
                                                    </div>
                                                @endif

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.igta') }}</h6>
                                                    <p class="text-dark">{{ $medicine->igta ?: __('medicine.na') }}</p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.hns_code') }}</h6>
                                                    <p class="text-dark">{{ $medicine->hns_code ?: __('medicine.na') }}
                                                    </p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.serial_number') }}</h6>
                                                    <p class="text-dark">
                                                        {{ $medicine->serial_number ?: __('medicine.na') }}</p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">{{ __('medicine.lot_number') }}</h6>
                                                    <p class="text-dark">{{ $medicine->lot_number ?: __('medicine.na') }}
                                                    </p>
                                                </div>

                                                @if ($medicine->medicine_categories->count() > 0)
                                                    <div class="col-md-12 mb-3">
                                                        <h6 class="text-muted mb-1">{{ __('medicine.categories') }}</h6>
                                                        <div>
                                                            @foreach ($medicine->medicine_categories as $category)
                                                                <span
                                                                    class="badge bg-primary me-1">{{ $category->name }}</span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
