@extends('layouts.app')

@section('title', __('supplier.suppliers'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('supplier.suppliers'),
        'subtitle' => __('supplier.manage_suppliers'),
        'button' => [
            'text' => __('supplier.create_supplier'),
            'url' => route('suppliers.create'),
            'icon' => 'plus',
        ],
    ])

    <div class="card table-list-card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-input">
                        <a href="" class="btn btn-searchset"><i data-feather="search" class="feather-search"></i></a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table datanew">
                    <thead>
                        <tr>
                            <th class="no-sort">
                                {{ __('supplier.sn') }}
                            </th>
                            <th>{{ __('supplier.name') }}</th>
                            <th>{{ __('supplier.phone') }}</th>
                            <th>{{ __('supplier.email') }}</th>
                            <th>{{ __('supplier.address') }}</th>
                            <th>{{ __('supplier.balance') }}</th>
                            <th>{{ __('supplier.created_on') }}</th>
                            <th class="no-sort">{{ __('supplier.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $supplier)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->phone }}</td>
                                <td>{{ $supplier->email }}</td>
                                <td>
                                    {{ $supplier->address }}
                                    @if ($supplier->city || $supplier->state || $supplier->zip)
                                        <br>
                                        {{ collect([$supplier->city, $supplier->state, $supplier->zip])->filter()->implode(', ') }}
                                    @endif
                                </td>
                                <td>
                                    @if ($supplier->opening_balance)
                                        <span
                                            class="badge bg-{{ $supplier->opening_balance_type === 'credit' ? 'success' : 'danger' }}">
                                            {{ $supplier->formatted_opening_balance }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">0.00</span>
                                    @endif
                                </td>
                                <td>{{ $supplier->created_at->format('d M Y') }}</td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('suppliers.edit', $supplier->id) }}"
                                            data-bs-toggle="tooltip" title="{{ __('supplier.edit') }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="p-2 me-2" href="{{ route('suppliers.show', $supplier->id) }}"
                                            data-bs-toggle="tooltip" title="{{ __('supplier.view') }}">
                                            <i data-feather="eye" class="feather-eye"></i>
                                        </a>
                                        <a class="confirm-text p-2" href="javascript:void(0);" data-bs-toggle="tooltip"
                                            title="{{ __('supplier.delete') }}" data-id="{{ $supplier->id }}">
                                            <i data-feather="trash-2" class="feather-trash-2"></i>
                                        </a>
                                        <form id="delete-form-{{ $supplier->id }}"
                                            action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).on('click', '.confirm-text', function() {
            var id = $(this).data('id');
            if (confirm("{{ __('supplier.delete_confirm') }}")) {
                $('#delete-form-' + id).submit();
            }
        });
    </script>
@endpush
