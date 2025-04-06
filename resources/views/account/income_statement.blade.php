@extends('layouts.app')

@section('title', 'Income Statement')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Income Statement</h3>
                    </div>
                    <div class="card-body">
                        <!-- Filter Form -->
                        <form action="{{ route('income-statement.index') }}" method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value="{{ $startDate }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            value="{{ $endDate }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="{{ route('income-statement.index') }}"
                                                class="btn btn-secondary">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Action Buttons -->
                        <div class="mb-3">
                            <a href="{{ route('income-statement.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                class="btn btn-info" target="_blank">
                                <i class="fas fa-print"></i> Print
                            </a>
                            <a href="{{ route('income-statement.download', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                class="btn btn-success">
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                        </div>

                        <!-- Income Statement Content -->
                        <div class="row">
                            <!-- Revenue Section -->
                            <div class="col-md-6">
                                <h4>Revenue</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Account</th>
                                                <th class="text-right">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($revenueBreakdown as $revenue)
                                                <tr>
                                                    <td>{{ $revenue['name'] }}</td>
                                                    <td class="text-right">{{ number_format($revenue['amount'], 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="font-weight-bold">
                                                <td>Total Revenue</td>
                                                <td class="text-right">{{ number_format($totalRevenue, 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- Expenses Section -->
                            <div class="col-md-6">
                                <h4>Expenses</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Account</th>
                                                <th class="text-right">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($expenseBreakdown as $expense)
                                                <tr>
                                                    <td>{{ $expense['name'] }}</td>
                                                    <td class="text-right">{{ number_format($expense['amount'], 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="font-weight-bold">
                                                <td>Total Expenses</td>
                                                <td class="text-right">{{ number_format($totalExpenses, 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Net Income Summary -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert {{ $netIncome >= 0 ? 'alert-success' : 'alert-danger' }}">
                                    <strong>Net Income:</strong>
                                    @if ($netIncome >= 0)
                                        The business made a profit of {{ number_format($netIncome, 2) }} during this
                                        period.
                                    @else
                                        The business incurred a loss of {{ number_format(abs($netIncome), 2) }} during this
                                        period.
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
