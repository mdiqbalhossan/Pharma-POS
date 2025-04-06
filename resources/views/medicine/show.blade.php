@extends('layouts.app')

@section('title', 'Medicine Details')

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'Medicine Details',
        'subtitle' => 'View medicine information',
    ])

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title mb-0">{{ $medicine->name }}</h4>
                        @if ($medicine->is_active)
                            <span class="badge bg-success ms-2">Active</span>
                        @else
                            <span class="badge bg-danger ms-2">Inactive</span>
                        @endif
                        @if ($medicine->prescription_required)
                            <span class="badge bg-warning ms-2">Prescription Required</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Left column with image and basic info -->
                        <div class="col-md-3 text-center mb-4">
                            @if ($medicine->image)
                                <img src="{{ Storage::url($medicine->image) }}" alt="{{ $medicine->name }}"
                                    class="img-fluid rounded mb-3" style="max-height: 200px;">
                            @else
                                <div class="border rounded d-flex align-items-center justify-content-center"
                                    style="height: 200px;">
                                    <i data-feather="image" style="width: 64px; height: 64px; color: #ccc;"></i>
                                </div>
                            @endif

                            <div class="d-grid gap-2 mt-3">
                                <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-primary">
                                    <i data-feather="edit" class="feather-sm me-1"></i> Edit
                                </a>
                                <button type="button" class="btn btn-danger confirm-text" data-id="{{ $medicine->id }}">
                                    <i data-feather="trash-2" class="feather-sm me-1"></i> Delete
                                </button>
                                <form id="delete-form-{{ $medicine->id }}"
                                    action="{{ route('medicines.destroy', $medicine->id) }}" method="POST"
                                    style="display: none;">
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
                                            <h5 class="mb-0"><i data-feather="info" class="feather-sm me-1"></i> Basic
                                                Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">Name</h6>
                                                    <p class="text-dark">{{ $medicine->name }}</p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">Generic Name</h6>
                                                    <p class="text-dark">{{ $medicine->generic_name ?: 'N/A' }}</p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">Barcode</h6>
                                                    <p class="text-dark">{{ $medicine->barcode ?: 'N/A' }}</p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">Medicine Type</h6>
                                                    <p class="text-dark">{{ $medicine->medicine_type->name ?? 'N/A' }}</p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">Medicine Leaf</h6>
                                                    <p class="text-dark">
                                                        {{ $medicine->medicine_leaf ? $medicine->medicine_leaf->type . ' (' . $medicine->medicine_leaf->qty_box . ')' : 'N/A' }}
                                                    </p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">Unit</h6>
                                                    <p class="text-dark">{{ $medicine->unit->name ?? 'N/A' }}</p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">Batch Number</h6>
                                                    <p class="text-dark">{{ $medicine->batch_number ?: 'N/A' }}</p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">Dosage</h6>
                                                    <p class="text-dark">{{ $medicine->dosage ?: 'N/A' }}</p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">Storage Condition</h6>
                                                    <p class="text-dark">{{ $medicine->storage_condition ?: 'N/A' }}</p>
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
                                                Pricing</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">Sale Price</h6>
                                                    <p class="text-dark fw-bold">
                                                        {{ number_format($medicine->sale_price, 2) }}</p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">Purchase Price</h6>
                                                    <p class="text-dark">{{ number_format($medicine->purchase_price, 2) }}
                                                    </p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">VAT (%)</h6>
                                                    <p class="text-dark">{{ $medicine->vat_percentage ?: '0' }}%</p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">Discount (%)</h6>
                                                    <p class="text-dark">{{ $medicine->discount_percentage ?: '0' }}%</p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">Loyalty Points</h6>
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
                                                Inventory</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">Quantity</h6>
                                                    <p class="text-dark">{{ $medicine->quantity ?: '0' }}</p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">Reorder Level</h6>
                                                    <p class="text-dark">{{ $medicine->reorder_level ?: 'N/A' }}</p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">Alert Quantity</h6>
                                                    <p class="text-dark">{{ $medicine->alert_quantity ?: 'N/A' }}</p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">Shelf</h6>
                                                    <p class="text-dark">{{ $medicine->shelf ?: 'N/A' }}</p>
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
                                                Supplier & Vendor</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">Supplier</h6>
                                                    <p class="text-dark">{{ $medicine->supplier->name ?? 'N/A' }}</p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">Vendor</h6>
                                                    <p class="text-dark">{{ $medicine->vendor->name ?? 'N/A' }}</p>
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
                                                Dates</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">Manufacturing Date</h6>
                                                    <p class="text-dark">
                                                        {{ $medicine->manufacturing_date ? date('M d, Y', strtotime($medicine->manufacturing_date)) : 'N/A' }}
                                                    </p>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6 class="text-muted mb-1">Expiration Date</h6>
                                                    <p class="text-dark">
                                                        @if ($medicine->expiration_date)
                                                            {{ date('M d, Y', strtotime($medicine->expiration_date)) }}
                                                            @php
                                                                $now = new DateTime();
                                                                $expiry = new DateTime($medicine->expiration_date);
                                                                $diff = $now->diff($expiry);
                                                            @endphp
                                                            @if ($now > $expiry)
                                                                <span class="badge bg-danger">Expired</span>
                                                            @elseif($diff->days < 30)
                                                                <span class="badge bg-warning">Expiring Soon</span>
                                                            @endif
                                                        @else
                                                            N/A
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
                                                Additional Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @if ($medicine->description)
                                                    <div class="col-md-12 mb-3">
                                                        <h6 class="text-muted mb-1">Description</h6>
                                                        <p class="text-dark">{{ $medicine->description }}</p>
                                                    </div>
                                                @endif

                                                @if ($medicine->side_effects)
                                                    <div class="col-md-12 mb-3">
                                                        <h6 class="text-muted mb-1">Side Effects</h6>
                                                        <p class="text-dark">{{ $medicine->side_effects }}</p>
                                                    </div>
                                                @endif

                                                @if ($medicine->contraindications)
                                                    <div class="col-md-12 mb-3">
                                                        <h6 class="text-muted mb-1">Contraindications</h6>
                                                        <p class="text-dark">{{ $medicine->contraindications }}</p>
                                                    </div>
                                                @endif

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">IGTA</h6>
                                                    <p class="text-dark">{{ $medicine->igta ?: 'N/A' }}</p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">HNS Code</h6>
                                                    <p class="text-dark">{{ $medicine->hns_code ?: 'N/A' }}</p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">Serial Number</h6>
                                                    <p class="text-dark">{{ $medicine->serial_number ?: 'N/A' }}</p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <h6 class="text-muted mb-1">Lot Number</h6>
                                                    <p class="text-dark">{{ $medicine->lot_number ?: 'N/A' }}</p>
                                                </div>

                                                @if ($medicine->medicine_categories->count() > 0)
                                                    <div class="col-md-12 mb-3">
                                                        <h6 class="text-muted mb-1">Categories</h6>
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

@push('script')
    <script>
        // Script for delete confirmation
        $(document).on('click', '.confirm-text', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        });
    </script>
@endpush
