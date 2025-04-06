@extends('layouts.app')

@section('title', 'Roles & Permissions')

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'Roles & Permissions',
        'subtitle' => 'Manage your roles',
        'button' => [
            'text' => 'Create Role',
            'url' => route('roles.create'),
            'icon' => 'plus'
        ]
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
                            <th class="no-sort">
                                SN
                            </th>
                            <th>Role Name</th>
                            <th>Created On</th>
                            <th class="no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->created_at->format('d M Y') }}</td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2" href="{{ route('roles.edit', $role->id) }}" data-bs-toggle="tooltip" title="Edit">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a class="p-2 me-2" href="{{ route('roles.show', $role->id) }}" data-bs-toggle="tooltip" title="Permissions">
                                        <i data-feather="shield" class="shield"></i>
                                    </a>
                                    <a class="confirm-text p-2" href="javascript:void(0);" data-bs-toggle="tooltip" title="Delete" data-id="{{ $role->id }}">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                    <form id="delete-form-{{ $role->id }}" action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: none;">
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