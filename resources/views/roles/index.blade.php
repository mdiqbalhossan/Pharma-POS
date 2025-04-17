@extends('layouts.app')

@section('title', __('Roles & Permissions'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('Roles & Permissions'),
        'subtitle' => __('Manage your roles'),
        'button' => [
            'text' => __('Create Role'),
            'url' => route('roles.create'),
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
                        <th class="no-sort">
                            {{ __('SN') }}
                        </th>
                        <th>{{ __('Role Name') }}</th>
                        <th>{{ __('Created On') }}</th>
                        <th class="no-sort">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->created_at->format('d M Y') }}</td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    @if ($role->name != 'admin')
                                        <a class="me-2 p-2" href="{{ route('roles.edit', $role->id) }}"
                                            data-bs-toggle="tooltip" title="{{ __('Edit') }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                    @endif

                                    <a class="p-2 me-2" href="{{ route('roles.show', $role->id) }}"
                                        data-bs-toggle="tooltip" title="{{ __('Permissions') }}">
                                        <i data-feather="shield" class="shield"></i>
                                    </a>
                                    @if ($role->name != 'admin')
                                        <a class="confirm-text p-2" href="javascript:void(0);" data-bs-toggle="tooltip"
                                            title="{{ __('Delete') }}" data-id="{{ $role->id }}">
                                            <i data-feather="trash-2" class="feather-trash-2"></i>
                                        </a>
                                    @endif
                                    <form id="delete-form-{{ $role->id }}"
                                        action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-none">
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
