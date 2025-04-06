@extends('layouts.app')

@section('title', 'Supplier Details')

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'Supplier Details',
        'subtitle' => 'View supplier information',
        'button' => [
            'text' => 'Back to Suppliers',
            'url' => route('suppliers.index'),
            'icon' => 'arrow-left'
        ]
    ])

    <div class="row">
        <div class="col-lg-8 col-xl-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Supplier Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1">Name</h6>
                            <p class="text-dark">{{ $supplier->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1">Phone</h6>
                            <p class="text-dark">{{ $supplier->phone }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1">Email</h6>
                            <p class="text-dark">{{ $supplier->email ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1">Address</h6>
                            <p class="text-dark">
                                {{ $supplier->address ?: 'N/A' }}
                                @if($supplier->city || $supplier->state || $supplier->zip)
                                    <br>
                                    {{ collect([$supplier->city, $supplier->state, $supplier->zip])->filter()->implode(', ') }}
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1">Balance</h6>
                            <p class="text-dark">
                                @if($supplier->opening_balance)
                                    <span class="badge bg-{{ $supplier->opening_balance_type === 'credit' ? 'success' : 'danger' }}">
                                        {{ $supplier->formatted_opening_balance }}
                                        ({{ ucfirst($supplier->opening_balance_type) }})
                                    </span>
                                @else
                                    <span class="badge bg-secondary">0.00</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1">Created At</h6>
                            <p class="text-dark">{{ $supplier->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-primary me-2">
                            <i data-feather="edit" class="feather-sm me-1"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger confirm-text" data-id="{{ $supplier->id }}">
                            <i data-feather="trash-2" class="feather-sm me-1"></i> Delete
                        </button>
                        <form id="delete-form-{{ $supplier->id }}" action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).on('click', '.confirm-text', function () {
            var id = $(this).data('id');
            if (confirm('Are you sure you want to delete this supplier?')) {
                $('#delete-form-' + id).submit();
            }
        });
    </script>
@endpush 