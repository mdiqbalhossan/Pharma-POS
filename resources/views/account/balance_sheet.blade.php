@extends('layouts.app')

@section('title', 'Balance Sheet')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Balance Sheet</h3>
                    </div>
                    <div class="card-body">
                        <!-- Filter Form -->
                        <form action="{{ route('balance-sheet.index') }}" method="GET" class="mb-4">
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
                                            <a href="{{ route('balance-sheet.index') }}" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Action Buttons -->
                        <div class="mb-3">
                            <a href="{{ route('balance-sheet.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                class="btn btn-info" target="_blank">
                                <i class="fas fa-print"></i> Print
                            </a>
                            <a href="{{ route('balance-sheet.download', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                class="btn btn-success">
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                        </div>

                        <!-- Balance Sheet Content -->
                        <div class="row">
                            <!-- Assets Section -->
                            <div class="col-md-6">
                                <h4>Assets</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Account</th>
                                                <th class="text-right">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($accountBalances as $account)
                                                @if ($account['type'] === 'asset')
                                                    <tr>
                                                        <td>{{ $account['name'] }}</td>
                                                        <td class="text-right">{{ number_format($account['balance'], 2) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="font-weight-bold">
                                                <td>Total Assets</td>
                                                <td class="text-right">{{ number_format($totalAssets, 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- Liabilities & Equity Section -->
                            <div class="col-md-6">
                                <h4>Liabilities & Equity</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Account</th>
                                                <th class="text-right">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Liabilities -->
                                            @foreach ($accountBalances as $account)
                                                @if ($account['type'] === 'liability')
                                                    <tr>
                                                        <td>{{ $account['name'] }}</td>
                                                        <td class="text-right">{{ number_format($account['balance'], 2) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td><strong>Total Liabilities</strong></td>
                                                <td class="text-right">{{ number_format($totalLiabilities, 2) }}</td>
                                            </tr>

                                            <!-- Equity -->
                                            @foreach ($accountBalances as $account)
                                                @if ($account['type'] === 'equity')
                                                    <tr>
                                                        <td>{{ $account['name'] }}</td>
                                                        <td class="text-right">{{ number_format($account['balance'], 2) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td><strong>Total Equity</strong></td>
                                                <td class="text-right">{{ number_format($totalEquity, 2) }}</td>
                                            </tr>

                                            <!-- Net Income -->
                                            <tr>
                                                <td><strong>Net Income</strong></td>
                                                <td class="text-right">{{ number_format($netIncome, 2) }}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="font-weight-bold">
                                                <td>Total Liabilities & Equity</td>
                                                <td class="text-right">{{ number_format($totalLiabilitiesAndEquity, 2) }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div
                                    class="alert {{ $totalAssets == $totalLiabilitiesAndEquity ? 'alert-success' : 'alert-danger' }}">
                                    <strong>Summary:</strong>
                                    @if ($totalAssets == $totalLiabilitiesAndEquity)
                                        The balance sheet is balanced. Total Assets ({{ number_format($totalAssets, 2) }})
                                        equals Total Liabilities & Equity
                                        ({{ number_format($totalLiabilitiesAndEquity, 2) }}).
                                    @else
                                        The balance sheet is not balanced. Total Assets
                                        ({{ number_format($totalAssets, 2) }}) does not equal Total Liabilities & Equity
                                        ({{ number_format($totalLiabilitiesAndEquity, 2) }}).
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
