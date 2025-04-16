@extends('layouts.app')

@section('title', __('account.trial_balance'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('account.trial_balance') }}</h3>
                    </div>
                    <div class="card-body">
                        <!-- Filter Form -->
                        <form action="{{ route('trial-balance.index') }}" method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="start_date">{{ __('account.from_date') }}</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value="{{ $startDate }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="end_date">{{ __('account.to_date') }}</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            value="{{ $endDate }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="d-flex gap-2">
                                            <button type="submit"
                                                class="btn btn-primary">{{ __('account.generate') }}</button>
                                            <a href="{{ route('trial-balance.index') }}"
                                                class="btn btn-secondary">{{ __('account.reset') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Action Buttons -->
                        <div class="mb-3">
                            <a href="{{ route('trial-balance.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                class="btn btn-info" target="_blank">
                                <i class="fas fa-print"></i> {{ __('account.print') }}
                            </a>
                            <a href="{{ route('trial-balance.download', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                class="btn btn-success">
                                <i class="fas fa-download"></i> {{ __('account.download_pdf') }}
                            </a>
                        </div>

                        <!-- Trial Balance Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('account.name') }}</th>
                                        <th>{{ __('account.type') }}</th>
                                        <th class="text-right">{{ __('account.debit') }}</th>
                                        <th class="text-right">{{ __('account.credit') }}</th>
                                        <th class="text-right">{{ __('account.balance') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accounts as $account)
                                        <tr>
                                            <td>{{ $account['name'] }}</td>
                                            <td>{{ ucfirst($account['type']) }}</td>
                                            <td class="text-right">{{ show_amount($account['debit']) }}</td>
                                            <td class="text-right">{{ show_amount($account['credit']) }}</td>
                                            <td
                                                class="text-right {{ $account['balance'] < 0 ? 'text-danger' : 'text-success' }}">
                                                {{ show_amount($account['balance']) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="font-weight-bold">
                                        <td colspan="2">{{ __('account.total') }}</td>
                                        <td class="text-right">{{ show_amount($totalDebit) }}</td>
                                        <td class="text-right">{{ show_amount($totalCredit) }}</td>
                                        <td class="text-right {{ $totalBalance < 0 ? 'text-danger' : 'text-success' }}">
                                            {{ show_amount($totalBalance) }}
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
