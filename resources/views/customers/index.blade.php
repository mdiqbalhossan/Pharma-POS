@extends('layouts.app')

@section('title', __('customers.customers'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('customers.customers'),
        'subtitle' => __('customers.manage_customers'),
        'button' => [
            'text' => __('customers.create_customer'),
            'url' => route('customers.create'),
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
                            {{ __('customers.sn') }}
                        </th>
                        <th>{{ __('customers.name') }}</th>
                        <th>{{ __('customers.phone') }}</th>
                        <th>{{ __('customers.email') }}</th>
                        <th>{{ __('customers.address') }}</th>
                        <th>{{ __('customers.balance') }}</th>
                        <th>{{ __('customers.created_on') }}</th>
                        <th class="no-sort">{{ __('customers.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>
                                {{ $customer->address }}
                                @if ($customer->city || $customer->state || $customer->zip)
                                    <br>
                                    {{ collect([$customer->city, $customer->state, $customer->zip])->filter()->implode(', ') }}
                                @endif
                            </td>
                            <td>
                                @if ($customer->opening_balance)
                                    <span
                                        class="badge bg-{{ $customer->opening_balance_type === 'credit' ? 'success' : 'danger' }}">
                                        {{ $customer->formatted_opening_balance }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">0.00</span>
                                @endif
                            </td>
                            <td>{{ $customer->created_at->format('d M Y') }}</td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2" href="{{ route('customers.edit', $customer->id) }}"
                                        data-bs-toggle="tooltip" title="{{ __('customers.edit_tooltip') }}">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a class="p-2 me-2" href="{{ route('customers.show', $customer->id) }}"
                                        data-bs-toggle="tooltip" title="{{ __('customers.view_tooltip') }}">
                                        <i data-feather="eye" class="feather-eye"></i>
                                    </a>
                                    <a class="confirm-text p-2" href="javascript:void(0);" data-bs-toggle="tooltip"
                                        title="{{ __('customers.delete_tooltip') }}" data-id="{{ $customer->id }}">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                    <form id="delete-form-{{ $customer->id }}"
                                        action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                        class="d-none">
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
