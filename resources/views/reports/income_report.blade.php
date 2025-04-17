@extends('layouts.app')

@section('title', __('Income Report'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <!-- Charts CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/apexchart/apexcharts.css') }}">
@endpush

@section('content')
    <div class="page-header report">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>{{ __('Income Report') }}</h4>
                <h6>{{ __('Track income sources and trends') }}</h6>
            </div>
        </div>
    </div>

    <!-- Report filter -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('reports.income') }}" method="GET">
                <div class="row">
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('From Date') }}</label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" name="start_date" class="datetimepicker"
                                    placeholder="{{ __('Choose Date') }}" value="{{ request('start_date') ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>{{ __('To Date') }}</label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" name="end_date" class="datetimepicker"
                                    placeholder="{{ __('Choose Date') }}" value="{{ request('end_date') ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                            <a href="{{ route('reports.income') }}" class="btn btn-info ms-2">{{ __('Reset') }}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Income Summary -->
    <div class="row">
        <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($salesIncome, 2) }}</h4>
                    <h5>{{ __('Sales Revenue') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($otherIncome, 2) }}</h4>
                    <h5>{{ __('Other Income') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($totalIncome, 2) }}</h4>
                    <h5>{{ __('Total Income') }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Income Chart -->
    @if (count($incomeByDate) > 0)
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Income Trend') }}</h5>
            </div>
            <div class="card-body">
                <div id="income-chart"></div>
            </div>
        </div>
    @endif

    <!-- Income by Date -->
    @if (count($incomeByDate) > 0)
        <div class="card table-list-card">
            <div class="card-header">
                <h5>{{ __('Income by Date') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew list">
                        <thead>
                            <tr>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Sales Revenue') }}</th>
                                <th>{{ __('Other Income') }}</th>
                                <th>{{ __('Total Income') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($incomeByDate as $date => $income)
                                <tr>
                                    <td>{{ $income['date'] }}</td>
                                    <td>{{ show_amount($income['sales'], 2) }}</td>
                                    <td>{{ show_amount($income['other'], 2) }}</td>
                                    <td>{{ show_amount($income['total'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
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
    <!-- Chart JS -->
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>

    {{-- Internal JS use dynamically change the chart data --}}
    <script>
        @if (count($incomeByDate) > 0)
            // Chart data
            var dates = [];
            var salesData = [];
            var otherData = [];
            var totalData = [];

            @foreach ($incomeByDate as $date => $income)
                dates.push("{{ $income['date'] }}");
                salesData.push({{ $income['sales'] }});
                otherData.push({{ $income['other'] }});
                totalData.push({{ $income['total'] }});
            @endforeach

            var options = {
                series: [{
                    name: '{{ __('Sales Revenue') }}',
                    data: salesData
                }, {
                    name: '{{ __('Other Income') }}',
                    data: otherData
                }, {
                    name: '{{ __('Total Income') }}',
                    data: totalData
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: [2, 2, 4],
                    dashArray: [0, 0, 0]
                },
                xaxis: {
                    categories: dates,
                },
                yaxis: {
                    title: {
                        text: '{{ __('Amount') }}'
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val.toFixed(2)
                        }
                    }
                },
                legend: {
                    position: 'top'
                }
            };

            var chart = new ApexCharts(document.querySelector("#income-chart"), options);
            chart.render();
        @endif
    </script>
@endpush
