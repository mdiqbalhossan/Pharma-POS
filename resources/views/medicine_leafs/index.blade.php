@extends('layouts.app')

@section('title', __('medicine_leafs.title'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('medicine_leafs.title'),
        'subtitle' => __('medicine_leafs.manage_all'),
        'button' => [
            'text' => __('medicine_leafs.create_medicine_leaf'),
            'url' => route('medicine-leafs.create'),
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
                            <th class="no-sort">{{ __('medicine_leafs.sn') }}</th>
                            <th>{{ __('medicine_leafs.type') }}</th>
                            <th>{{ __('medicine_leafs.quantity_per_box') }}</th>
                            <th>{{ __('medicine_leafs.created_on') }}</th>
                            <th class="no-sort">{{ __('medicine_leafs.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicineLeafs as $leaf)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $leaf->type }}</td>
                                <td>{{ $leaf->qty_box }}</td>
                                <td>{{ $leaf->created_at->format('d M Y') }}</td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('medicine-leafs.edit', $leaf->id) }}"
                                            data-bs-toggle="tooltip" title="{{ __('medicine_leafs.edit') }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="confirm-text p-2" href="javascript:void(0);" data-bs-toggle="tooltip"
                                            title="{{ __('medicine_leafs.delete') }}" data-id="{{ $leaf->id }}">
                                            <i data-feather="trash-2" class="feather-trash-2"></i>
                                        </a>
                                        <form id="delete-form-{{ $leaf->id }}"
                                            action="{{ route('medicine-leafs.destroy', $leaf->id) }}" method="POST"
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
