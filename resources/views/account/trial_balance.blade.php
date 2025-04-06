@extends('layouts.app')

@section('title', 'Trial Balance')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Trial Balance</h3>
                    </div>
                    <div class="card-body">
                        <!-- Filter Form -->
                        <form action="{{ route('trial-balance.index') }}" method="GET" class="mb-4">
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
                                            <a href="{{ route('trial-balance.index') }}" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Action Buttons -->
                        <div class="mb-3">
                            <a href="{{ route('trial-balance.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                class="btn btn-info" target="_blank">
                                <i class="fas fa-print"></i> Print
                            </a>
                            <a href="{{ route('trial-balance.download', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                class="btn btn-success">
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                        </div>

                        <!-- Trial Balance Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Account Name</th>
                                        <th>Type</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accounts as $account)
                                        <tr>
                                            <td>{{ $account['name'] }}</td>
                                            <td>{{ ucfirst($account['type']) }}</td>
                                            <td class="text-right">{{ number_format($account['debit'], 2) }}</td>
                                            <td class="text-right">{{ number_format($account['credit'], 2) }}</td>
                                            <td
                                                class="text-right {{ $account['balance'] < 0 ? 'text-danger' : 'text-success' }}">
                                                {{ number_format($account['balance'], 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="font-weight-bold">
                                        <td colspan="2">Total</td>
                                        <td class="text-right">{{ number_format($totalDebit, 2) }}</td>
                                        <td class="text-right">{{ number_format($totalCredit, 2) }}</td>
                                        <td class="text-right {{ $totalBalance < 0 ? 'text-danger' : 'text-success' }}">
                                            {{ number_format($totalBalance, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
