@extends('layouts.app')

@section('title', __('Vendors'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('Vendors'),
        'subtitle' => __('Manage your vendors'),
        'button' => [
            'text' => __('Create Vendor'),
            'url' => route('vendors.create'),
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
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Phone') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Address') }}</th>
                        <th>{{ __('Balance') }}</th>
                        <th>{{ __('Created On') }}</th>
                        <th class="no-sort">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vendors as $vendor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $vendor->name }}</td>
                            <td>{{ $vendor->phone }}</td>
                            <td>{{ $vendor->email }}</td>
                            <td>
                                {{ $vendor->address }}
                                @if ($vendor->city || $vendor->state || $vendor->zip)
                                    <br>
                                    {{ collect([$vendor->city, $vendor->state, $vendor->zip])->filter()->implode(', ') }}
                                @endif
                            </td>
                            <td>
                                @if ($vendor->opening_balance)
                                    <span
                                        class="badge bg-{{ $vendor->opening_balance_type === 'credit' ? 'success' : 'danger' }}">
                                        {{ $vendor->formatted_opening_balance }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">0.00</span>
                                @endif
                            </td>
                            <td>{{ $vendor->created_at->format('d M Y') }}</td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2" href="{{ route('vendors.edit', $vendor->id) }}"
                                        data-bs-toggle="tooltip" title="{{ __('Edit') }}">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a class="p-2 me-2" href="{{ route('vendors.show', $vendor->id) }}"
                                        data-bs-toggle="tooltip" title="{{ __('View') }}">
                                        <i data-feather="eye" class="feather-eye"></i>
                                    </a>
                                    <a class="confirm-text p-2" href="javascript:void(0);" data-bs-toggle="tooltip"
                                        title="{{ __('Delete') }}" data-id="{{ $vendor->id }}">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                    <form id="delete-form-{{ $vendor->id }}"
                                        action="{{ route('vendors.destroy', $vendor->id) }}" method="POST"
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
