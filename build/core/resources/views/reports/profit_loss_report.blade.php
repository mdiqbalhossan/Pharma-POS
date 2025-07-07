@extends('layouts.app')

@section('title', __('Profit & Loss Report'))

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
                <h4>{{ __('Profit & Loss Report') }}</h4>
                <h6>{{ __('View financial performance summary') }}</h6>
            </div>
        </div>
    </div>

    <!-- Report filter -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('reports.profit-loss') }}" method="GET">
                <div class="row">
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('From Date') }}</label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" name="start_date" class="datetimepicker"
                                    placeholder="{{ __('Choose Date') }}"
                                    value="{{ request('start_date') ?? $start_date->format('d-m-Y') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('To Date') }}</label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" name="end_date" class="datetimepicker"
                                    placeholder="{{ __('Choose Date') }}"
                                    value="{{ request('end_date') ?? $end_date->format('d-m-Y') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                            <a href="{{ route('reports.profit-loss') }}" class="btn btn-info ms-2">{{ __('Reset') }}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Profit & Loss Statement -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>{{ __('Profit & Loss Statement') }}</h5>
                <div>
                    <span class="badge bg-primary me-2">{{ $start_date->format('d M Y') }}</span> {{ __('to') }}
                    <span class="badge bg-primary ms-2">{{ $end_date->format('d M Y') }}</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <!-- Income Section -->
                        <tr>
                            <th colspan="2">{{ __('Income') }}</th>
                        </tr>
                        <tr>
                            <td>{{ __('Sales Revenue') }}</td>
                            <td class="text-end">{{ show_amount($salesRevenue, 2) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Other Income') }}</td>
                            <td class="text-end">{{ show_amount($otherIncome, 2) }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Total Income') }}</th>
                            <th class="text-end">{{ show_amount($totalIncome, 2) }}</th>
                        </tr>

                        <!-- Cost of Sales Section -->
                        <tr>
                            <th colspan="2">{{ __('Cost of Sales') }}</th>
                        </tr>
                        <tr>
                            <td>{{ __('Cost of Goods Sold') }}</td>
                            <td class="text-end">{{ show_amount($costOfGoodsSold, 2) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Direct Expenses') }}</td>
                            <td class="text-end">{{ show_amount($directExpenses, 2) }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Total Cost of Sales') }}</th>
                            <th class="text-end">{{ show_amount($costOfGoodsSold + $directExpenses, 2) }}</th>
                        </tr>

                        <!-- Gross Profit -->
                        <tr>
                            <th>{{ __('Gross Profit') }}</th>
                            <th class="text-end">{{ show_amount($grossProfit, 2) }}</th>
                        </tr>

                        <!-- Operating Expenses -->
                        <tr>
                            <th colspan="2">{{ __('Operating Expenses') }}</th>
                        </tr>
                        <tr>
                            <td>{{ __('Indirect Expenses') }}</td>
                            <td class="text-end">{{ show_amount($indirectExpenses, 2) }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Total Operating Expenses') }}</th>
                            <th class="text-end">{{ show_amount($indirectExpenses, 2) }}</th>
                        </tr>

                        <!-- Net Profit -->
                        <tr class="{{ $netProfit >= 0 ? 'thead-success' : 'thead-danger' }}">
                            <th>{{ __('Net Profit') }} {{ $netProfit >= 0 ? '' : '(' . __('Loss') . ')' }}</th>
                            <th class="text-end">{{ show_amount(abs($netProfit), 2) }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Profit & Loss Summary -->
    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($totalIncome, 2) }}</h4>
                    <h5>{{ __('Total Income') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($totalExpenses, 2) }}</h4>
                    <h5>{{ __('Total Expenses') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($grossProfit, 2) }}</h4>
                    <h5>{{ __('Gross Profit') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count {{ $netProfit >= 0 ? 'border' : 'bg-danger text-white border-0' }}">
                <div class="dash-counts">
                    <h4>{{ show_amount(abs($netProfit), 2) }}</h4>
                    <h5>{{ __('Net Profit') }} {{ $netProfit >= 0 ? '' : '(' . __('Loss') . ')' }}</h5>
                </div>
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
