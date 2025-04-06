@extends('layouts.app')

@section('title', 'Medicines')

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'Medicines',
        'subtitle' => 'Manage your medicines',
        'button' => [
            'text' => 'Create Medicine',
            'url' => route('medicines.create'),
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
                            <th class="no-sort">SN</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Generic Name</th>
                            <th>Type</th>
                            <th>Unit</th>
                            <th>Sale Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th class="no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicines as $medicine)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($medicine->image)
                                        <img src="{{ Storage::url($medicine->image) }}" alt="{{ $medicine->name }}"
                                            class="img-thumbnail" width="50">
                                    @else
                                        <img src="{{ asset('assets/img/placeholder.png') }}" alt="{{ $medicine->name }}"
                                            class="img-thumbnail" width="50">
                                    @endif
                                </td>
                                <td>{{ $medicine->name }}</td>
                                <td>{{ $medicine->generic_name ?? 'N/A' }}</td>
                                <td>{{ $medicine->medicine_type->name ?? 'N/A' }}</td>
                                <td>{{ $medicine->unit->name ?? 'N/A' }}</td>
                                <td>{{ number_format($medicine->sale_price, 2) }}</td>
                                <td>
                                    @if ($medicine->quantity > 0)
                                        @if ($medicine->quantity <= $medicine->alert_quantity)
                                            <span class="badge bg-warning">{{ $medicine->quantity }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $medicine->quantity }}</span>
                                        @endif
                                    @else
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($medicine->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('medicines.edit', $medicine->id) }}"
                                            data-bs-toggle="tooltip" title="Edit">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="p-2 me-2" href="{{ route('medicines.show', $medicine->id) }}"
                                            data-bs-toggle="tooltip" title="View">
                                            <i data-feather="eye" class="feather-eye"></i>
                                        </a>
                                        <a class="confirm-text p-2" href="javascript:void(0);" data-bs-toggle="tooltip"
                                            title="Delete" data-id="{{ $medicine->id }}">
                                            <i data-feather="trash-2" class="feather-trash-2"></i>
                                        </a>
                                        <form id="delete-form-{{ $medicine->id }}"
                                            action="{{ route('medicines.destroy', $medicine->id) }}" method="POST"
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
@endpush
