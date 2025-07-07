@extends('layouts.app')

@section('title', __('index.Transaction'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('index.Transaction'),
        'subtitle' => __('index.Manage your transactions'),
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
                            <th>{{ __('index.Transaction ID') }}</th>
                            <th>{{ __('index.Account') }}</th>
                            <th>{{ __('index.Type') }}</th>
                            <th>{{ __('index.Amount') }}</th>
                            <th>{{ __('index.Date') }}</th>
                            <th>{{ __('index.Description') }}</th>
                            <th>{{ __('index.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->transaction_id }}</td>
                                <td>{{ $transaction->account->name }}</td>
                                <td>
                                    <span class="badge badge-{{ $transaction->type === 'credit' ? 'success' : 'danger' }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td>{{ show_amount($transaction->amount) }}</td>
                                <td>{{ Carbon\Carbon::parse($transaction->transaction_date)->format('d M, Y') }}</td>
                                <td>{{ $transaction->description }}</td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('transactions.show', $transaction) }}"
                                            data-bs-toggle="tooltip" title="{{ __('index.View') }}">
                                            <i data-feather="eye" class="feather-eye"></i>
                                        </a>
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
