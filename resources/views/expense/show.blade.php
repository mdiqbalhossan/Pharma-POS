@extends('layouts.app')

@section('title', 'Expense Details')

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'Expense Details',
        'subtitle' => 'View expense information',
        'button' => [
            'text' => 'Back',
            'url' => route('expenses.index'),
            'icon' => 'arrow-left'
        ]
    ])

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Expense Information</h5>
                    <div>
                        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-primary btn-sm">
                            <i data-feather="edit" class="me-1"></i>Edit
                        </a>
                        <a class="btn btn-danger btn-sm confirm-text" href="javascript:void(0);" data-bs-toggle="tooltip" data-id="{{ $expense->id }}">
                            <i data-feather="trash-2" class="me-1"></i>Delete
                        </a>
                        <form id="delete-form-{{ $expense->id }}" action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display: none;">
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
                                    <th width="40%">Category</th>
                                    <td>{{ $expense->expenseCategory->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td>{{ $expense->formatted_date }}</td>
                                </tr>
                                <tr>
                                    <th>Expense For</th>
                                    <td>{{ $expense->expense_for }}</td>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    <td>{{ $expense->formatted_amount }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered table-details">
                                <tr>
                                    <th width="40%">Reference</th>
                                    <td>{{ $expense->reference ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $expense->description ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $expense->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
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

@push('script')
    <script>
        $(document).on('click', '.confirm-text', function () {
            var id = $(this).data('id');
            if (confirm('Are you sure you want to delete this expense?')) {
                $('#delete-form-' + id).submit();
            }
        });
    </script>
@endpush 