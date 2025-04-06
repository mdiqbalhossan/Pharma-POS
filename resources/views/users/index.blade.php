@extends('layouts.app')

@section('title', 'Users')

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'Users',
        'subtitle' => 'Manage your users',
        'button' => [
            'text' => 'Create User',
            'url' => route('users.create'),
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Created On</th>
                            <th class="no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge bg-primary">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2" href="{{ route('users.edit', $user->id) }}" data-bs-toggle="tooltip" title="Edit">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a class="p-2 me-2" href="{{ route('users.show', $user->id) }}" data-bs-toggle="tooltip" title="View">
                                        <i data-feather="eye" class="feather-eye"></i>
                                    </a>
                                    <a class="confirm-text p-2" href="javascript:void(0);" data-bs-toggle="tooltip" title="Delete" data-id="{{ $user->id }}">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: none;">
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