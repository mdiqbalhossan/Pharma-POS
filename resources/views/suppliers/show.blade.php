@extends('layouts.app')

@section('title', __('supplier.supplier_details'))

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('supplier.supplier_details'),
        'subtitle' => __('supplier.view_supplier_info'),
        'button' => [
            'text' => __('supplier.back_to_suppliers'),
            'url' => route('suppliers.index'),
            'icon' => 'arrow-left',
        ],
    ])

    <div class="row">
        <div class="col-lg-8 col-xl-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ __('supplier.supplier_information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1">{{ __('supplier.name') }}</h6>
                            <p class="text-dark">{{ $supplier->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1">{{ __('supplier.phone') }}</h6>
                            <p class="text-dark">{{ $supplier->phone }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1">{{ __('supplier.email') }}</h6>
                            <p class="text-dark">{{ $supplier->email ?: __('supplier.n_a') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1">{{ __('supplier.address') }}</h6>
                            <p class="text-dark">
                                {{ $supplier->address ?: __('supplier.n_a') }}
                                @if ($supplier->city || $supplier->state || $supplier->zip)
                                    <br>
                                    {{ collect([$supplier->city, $supplier->state, $supplier->zip])->filter()->implode(', ') }}
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1">{{ __('supplier.balance') }}</h6>
                            <p class="text-dark">
                                @if ($supplier->opening_balance)
                                    <span
                                        class="badge bg-{{ $supplier->opening_balance_type === 'credit' ? 'success' : 'danger' }}">
                                        {{ $supplier->formatted_opening_balance }}
                                        ({{ ucfirst($supplier->opening_balance_type) }})
                                    </span>
                                @else
                                    <span class="badge bg-secondary">0.00</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1">{{ __('supplier.created_at') }}</h6>
                            <p class="text-dark">{{ $supplier->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-primary me-2">
                            <i data-feather="edit" class="feather-sm me-1"></i> {{ __('supplier.edit') }}
                        </a>
                        <button type="button" class="btn btn-danger confirm-text" data-id="{{ $supplier->id }}">
                            <i data-feather="trash-2" class="feather-sm me-1"></i> {{ __('supplier.delete') }}
                        </button>
                        <form id="delete-form-{{ $supplier->id }}"
                            action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display: none;">
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
        $(document).on('click', '.confirm-text', function() {
            var id = $(this).data('id');
            if (confirm("{{ __('supplier.delete_confirm') }}")) {
                $('#delete-form-' + id).submit();
            }
        });
    </script>
@endpush
