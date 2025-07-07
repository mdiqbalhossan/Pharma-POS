@extends('layouts.app')

@section('title', __('expense.expense_details'))

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('expense.expense_details'),
        'subtitle' => __('expense.view_expense_information'),
        'button' => [
            'text' => __('expense.back'),
            'url' => route('expenses.index'),
            'icon' => 'arrow-left',
        ],
    ])

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">{{ __('expense.expense_information') }}</h5>
                    <div>
                        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-primary btn-sm">
                            <i data-feather="edit" class="me-1"></i>{{ __('expense.edit') }}
                        </a>
                        <a class="btn btn-danger btn-sm confirm-text" href="javascript:void(0);" data-bs-toggle="tooltip"
                            data-id="{{ $expense->id }}">
                            <i data-feather="trash-2" class="me-1"></i>{{ __('expense.delete') }}
                        </a>
                        <form id="delete-form-{{ $expense->id }}" action="{{ route('expenses.destroy', $expense->id) }}"
                            method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered table-details">
                                <tr>
                                    <th width="40%">{{ __('expense.category') }}</th>
                                    <td>{{ $expense->expenseCategory->name ?? __('expense.na') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('expense.date') }}</th>
                                    <td>{{ $expense->formatted_date }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('expense.expense_for') }}</th>
                                    <td>{{ $expense->expense_for }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('expense.amount') }}</th>
                                    <td>{{ $expense->formatted_amount }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered table-details">
                                <tr>
                                    <th width="40%">{{ __('expense.reference') }}</th>
                                    <td>{{ $expense->reference ?? __('expense.na') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('expense.description') }}</th>
                                    <td>{{ $expense->description ?? __('expense.na') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('expense.created_at') }}</th>
                                    <td>{{ $expense->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('expense.last_updated') }}</th>
                                    <td>{{ $expense->updated_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
