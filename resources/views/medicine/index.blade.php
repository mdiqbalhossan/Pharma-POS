@extends('layouts.app')

@section('title', __('medicine.medicines'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('medicine.medicines'),
        'subtitle' => __('medicine.manage_your_medicines'),
        'button' => [
            'text' => __('medicine.create_medicine'),
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
                            <th class="no-sort">{{ __('medicine.sn') }}</th>
                            <th>{{ __('medicine.image') }}</th>
                            <th>{{ __('medicine.name') }}</th>
                            <th>{{ __('medicine.generic_name') }}</th>
                            <th>{{ __('medicine.type') }}</th>
                            <th>{{ __('medicine.unit') }}</th>
                            <th>{{ __('medicine.sale_price') }}</th>
                            <th>{{ __('medicine.stock') }}</th>
                            <th>{{ __('medicine.status') }}</th>
                            <th class="no-sort">{{ __('medicine.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicines as $medicine)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset($medicine->image) }}" alt="{{ $medicine->name }}"
                                        class="img-thumbnail" width="50">
                                </td>
                                <td>{{ $medicine->name }}</td>
                                <td>{{ $medicine->generic_name ?? __('medicine.na') }}</td>
                                <td>{{ $medicine->medicine_type->name ?? __('medicine.na') }}</td>
                                <td>{{ $medicine->unit->name ?? __('medicine.na') }}</td>
                                <td>{{ show_amount($medicine->sale_price) }}</td>
                                <td>
                                    @if ($medicine->quantity > 0)
                                        @if ($medicine->quantity <= $medicine->alert_quantity)
                                            <span class="badge bg-warning">{{ $medicine->quantity }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $medicine->quantity }}</span>
                                        @endif
                                    @else
                                        <span class="badge bg-danger">{{ __('medicine.out_of_stock') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($medicine->is_active)
                                        <span class="badge bg-success">{{ __('medicine.active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __('medicine.inactive') }}</span>
                                    @endif
                                </td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('medicines.edit', $medicine->id) }}"
                                            data-bs-toggle="tooltip" title="{{ __('medicine.edit') }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="p-2 me-2" href="{{ route('medicines.show', $medicine->id) }}"
                                            data-bs-toggle="tooltip" title="{{ __('medicine.view') }}">
                                            <i data-feather="eye" class="feather-eye"></i>
                                        </a>
                                        <a class="confirm-text p-2" href="javascript:void(0);" data-bs-toggle="tooltip"
                                            title="{{ __('medicine.delete') }}" data-id="{{ $medicine->id }}">
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
