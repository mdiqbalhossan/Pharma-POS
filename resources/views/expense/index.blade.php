@extends('layouts.app')

@section('title', __('expense.expenses'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('expense.expenses'),
        'subtitle' => __('expense.manage_expenses'),
        'button' => [
            'text' => __('expense.create_expense'),
            'url' => route('expenses.create'),
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
                                {{ __('expense.sn') }}
                            </th>
                            <th>{{ __('expense.category') }}</th>
                            <th>{{ __('expense.date') }}</th>
                            <th>{{ __('expense.expense_for') }}</th>
                            <th>{{ __('expense.amount') }}</th>
                            <th>{{ __('expense.reference') }}</th>
                            <th>{{ __('expense.created_on') }}</th>
                            <th class="no-sort">{{ __('expense.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $expense->expenseCategory ? $expense->expenseCategory->name : __('expense.na') }}
                                </td>
                                <td>{{ $expense->formatted_date }}</td>
                                <td>{{ $expense->expense_for }}</td>
                                <td>{{ $expense->formatted_amount }}</td>
                                <td>{{ $expense->reference ?? __('expense.na') }}</td>
                                <td>{{ $expense->created_at->format('d M Y') }}</td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('expenses.edit', $expense->id) }}"
                                            data-bs-toggle="tooltip" title="{{ __('expense.edit') }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="p-2 me-2" href="{{ route('expenses.show', $expense->id) }}"
                                            data-bs-toggle="tooltip" title="{{ __('expense.view') }}">
                                            <i data-feather="eye" class="feather-eye"></i>
                                        </a>
                                        <a class="confirm-text p-2" href="javascript:void(0);" data-bs-toggle="tooltip"
                                            title="{{ __('expense.delete') }}" data-id="{{ $expense->id }}">
                                            <i data-feather="trash-2" class="feather-trash-2"></i>
                                        </a>
                                        <form id="delete-form-{{ $expense->id }}"
                                            action="{{ route('expenses.destroy', $expense->id) }}" method="POST"
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
