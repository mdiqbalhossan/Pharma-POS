@extends('layouts.app')

@section('title', __('account.accounts'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('account.accounts'),
        'subtitle' => __('account.manage_your_accounts'),
        'button' => [
            'text' => __('account.create_account'),
            'url' => route('accounts.create'),
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
                                {{ __('account.sn') }}
                            </th>
                            <th>{{ __('account.name') }}</th>
                            <th>{{ __('account.type') }}</th>
                            <th>{{ __('account.description') }}</th>
                            <th>{{ __('account.status') }}</th>
                            <th>{{ __('account.created_on') }}</th>
                            <th class="no-sort">{{ __('account.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $account)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->type }}</td>
                                <td>{{ $account->description ?? __('account.na') }}</td>
                                <td>
                                    @if ($account->is_active)
                                        <span class="badge bg-success">{{ __('account.active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __('account.inactive') }}</span>
                                    @endif
                                </td>
                                <td>{{ $account->created_at->format('d M Y') }}</td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('accounts.edit', $account->id) }}"
                                            data-bs-toggle="tooltip" title="{{ __('account.edit') }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="p-2 me-2" href="{{ route('accounts.show', $account->id) }}"
                                            data-bs-toggle="tooltip" title="{{ __('account.view') }}">
                                            <i data-feather="eye" class="feather-eye"></i>
                                        </a>
                                        <a class="confirm-text p-2" href="javascript:void(0);" data-bs-toggle="tooltip"
                                            title="{{ __('account.delete') }}" data-id="{{ $account->id }}">
                                            <i data-feather="trash-2" class="feather-trash-2"></i>
                                        </a>
                                        <form id="delete-form-{{ $account->id }}"
                                            action="{{ route('accounts.destroy', $account->id) }}" method="POST"
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
