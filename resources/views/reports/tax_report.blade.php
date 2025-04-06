@extends('layouts.app')

@section('title', 'Tax Report')

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
                <h4>Tax Report</h4>
                <h6>View and analyze your tax data</h6>
            </div>
        </div>
    </div>

    <!-- Report filter -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('reports.tax') }}" method="GET">
                <div class="row">
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>From Date</label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" name="start_date" class="datetimepicker" placeholder="Choose Date"
                                    value="{{ request('start_date') ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>To Date</label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" name="end_date" class="datetimepicker" placeholder="Choose Date"
                                    value="{{ request('end_date') ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('reports.tax') }}" class="btn btn-info ms-2">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tax Summary -->
    <div class="row">
        <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($salesTax, 2) }}</h4>
                    <h5>Sales Tax</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($purchaseTax, 2) }}</h4>
                    <h5>Purchase Tax</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($netTax, 2) }}</h4>
                    <h5>Net Tax</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Tax Chart -->
    @if (count($taxByMonth) > 0)
        <div class="card">
            <div class="card-header">
                <h5>Tax Trend by Month</h5>
            </div>
            <div class="card-body">
                <div id="tax-chart"></div>
            </div>
        </div>
    @endif

    <!-- Tax by Month -->
    @if (count($taxByMonth) > 0)
        <div class="card table-list-card">
            <div class="card-header">
                <h5>Tax by Month</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew list">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Sales Tax</th>
                                <th>Purchase Tax</th>
                                <th>Net Tax</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($taxByMonth as $month => $tax)
                                <tr>
                                    <td>{{ $tax['month'] }}</td>
                                    <td>{{ show_amount($tax['sales_tax'], 2) }}</td>
                                    <td>{{ show_amount($tax['purchase_tax'], 2) }}</td>
                                    <td>{{ show_amount($tax['net_tax'], 2) }}</td>
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
    <script>
        @if (count($taxByMonth) > 0)
            // Chart data
            var months = [];
            var salesTaxData = [];
            var purchaseTaxData = [];
            var netTaxData = [];

            @foreach ($taxByMonth as $month => $tax)
                months.push("{{ $tax['month'] }}");
                salesTaxData.push({{ $tax['sales_tax'] }});
                purchaseTaxData.push({{ $tax['purchase_tax'] }});
                netTaxData.push({{ $tax['net_tax'] }});
            @endforeach

            var options = {
                series: [{
                    name: 'Sales Tax',
                    data: salesTaxData
                }, {
                    name: 'Purchase Tax',
                    data: purchaseTaxData
                }, {
                    name: 'Net Tax',
                    data: netTaxData
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: months,
                },
                yaxis: {
                    title: {
                        text: 'Amount'
                    }
                },
                fill: {
                    opacity: 1
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

            var chart = new ApexCharts(document.querySelector("#tax-chart"), options);
            chart.render();
        @endif
    </script>
@endpush
