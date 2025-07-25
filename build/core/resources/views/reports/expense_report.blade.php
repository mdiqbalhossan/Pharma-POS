@extends('layouts.app')

@section('title', __('reports.expense_report'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endpush

@section('content')
    <div class="page-header report">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>{{ __('reports.expense_report') }}</h4>
                <h6>{{ __('reports.track_and_analyze_expense_trends') }}</h6>
            </div>
        </div>
    </div>

    <!-- Report filter -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('reports.expenses') }}" method="GET">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('reports.expense_category') }}</label>
                            <select name="category_id" class="select2">
                                <option value="">{{ __('reports.all_categories') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('reports.from_date') }}</label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" name="start_date" class="datetimepicker"
                                    placeholder="{{ __('reports.choose_date') }}"
                                    value="{{ request('start_date') ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('reports.to_date') }}</label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" name="end_date" class="datetimepicker"
                                    placeholder="{{ __('reports.choose_date') }}" value="{{ request('end_date') ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary">{{ __('reports.search') }}</button>
                            <a href="{{ route('reports.expenses') }}"
                                class="btn btn-info ms-2">{{ __('reports.reset') }}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Expense Summary -->
    <div class="row">
        <div class="col-lg-4 col-sm-12 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($totalExpenses, 2) }}</h4>
                    <h5>{{ __('reports.total_expenses') }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Expense List -->
    <div class="card table-list-card">
        <div class="card-body">
            <div class="table-responsive product-list">
                <table class="table datanew list">
                    <thead>
                        <tr>
                            <th>{{ __('reports.date') }}</th>
                            <th>{{ __('reports.reference_no') }}</th>
                            <th>{{ __('reports.expense_category') }}</th>
                            <th>{{ __('reports.amount') }}</th>
                            <th>{{ __('reports.note') }}</th>
                            <th class="no-sort">{{ __('reports.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</td>
                                <td>#{{ $expense->reference }}</td>
                                <td>{{ $expense->expenseCategory ? $expense->expenseCategory->name : __('N/A') }}</td>
                                <td>{{ show_amount($expense->amount, 2) }}</td>
                                <td>{{ $expense->note ? $expense->note : __('N/A') }}</td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('expenses.show', $expense->id) }}">
                                            <i data-feather="eye" class="action-eye"></i>
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
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Datetimepicker JS -->
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
@endpush
