@extends('layouts.app')

@section('title', __('Stores'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('Stores'),
        'subtitle' => __('Manage Stores'),
        'button' => [
            'text' => __('Create Store'),
            'url' => route('stores.create'),
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
        </div>
        <div class="table-responsive">
            <table class="table datanew">
                <thead>
                    <tr>
                        <th class="no-sort">SN</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Owner</th>
                        <th>Created On</th>
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stores as $store)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $store->name }}</td>
                            <td>{{ $store->email }}</td>
                            <td>{{ $store->phone }}</td>
                            <td>{{ $store->address }}</td>
                            <td>
                                <span class="badge bg-{{ $store->status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($store->status) }}
                                </span>
                            </td>
                            <td>{{ $store->user->name }}</td>
                            <td>{{ $store->created_at->format('d M Y') }}</td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2" href="{{ route('stores.edit', $store->id) }}"
                                        data-bs-toggle="tooltip" title="Edit Store">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a class="p-2 me-2" href="{{ route('stores.show', $store->id) }}"
                                        data-bs-toggle="tooltip" title="View Store">
                                        <i data-feather="eye" class="feather-eye"></i>
                                    </a>
                                    <a class="confirm-text p-2" href="javascript:void(0);" data-bs-toggle="tooltip"
                                        title="Delete Store" data-id="{{ $store->id }}">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                    <form id="delete-form-{{ $store->id }}"
                                        action="{{ route('stores.destroy', $store->id) }}" method="POST" class="d-none">
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
@endsection

@push('script')
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
@endpush
