@extends('layouts.app')

@section('title', __('expense_category.expense_categories'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('expense_category.expense_categories'),
        'subtitle' => __('expense_category.manage_expense_categories'),
        'button' => [
            'text' => __('expense_category.create_expense_category'),
            'url' => route('expense-categories.create'),
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
                            <th class="no-sort">{{ __('expense_category.sn') }}</th>
                            <th>{{ __('expense_category.name') }}</th>
                            <th>{{ __('expense_category.description') }}</th>
                            <th>{{ __('expense_category.created_on') }}</th>
                            <th class="no-sort">{{ __('expense_category.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenseCategories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description ?? __('expense_category.na') }}</td>
                                <td>{{ $category->created_at->format('d M Y') }}</td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('expense-categories.edit', $category->id) }}"
                                            data-bs-toggle="tooltip" title="{{ __('expense_category.edit') }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="confirm-text p-2" href="javascript:void(0);" data-bs-toggle="tooltip"
                                            title="{{ __('expense_category.delete') }}" data-id="{{ $category->id }}">
                                            <i data-feather="trash-2" class="feather-trash-2"></i>
                                        </a>
                                        <form id="delete-form-{{ $category->id }}"
                                            action="{{ route('expense-categories.destroy', $category->id) }}"
                                            method="POST" class="d-none">
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
