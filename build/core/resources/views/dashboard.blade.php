@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-widget w-100">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash1.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>$<span class="counters"
                            data-count="{{ $totalPurchaseDue }}">{{ number_format($totalPurchaseDue, 2) }}</span></h5>
                    <h6>{{ __('dashboard.total_purchase_due') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-widget dash1 w-100">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash2.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>$<span class="counters"
                            data-count="{{ $totalSalesDue }}">{{ number_format($totalSalesDue, 2) }}</span></h5>
                    <h6>{{ __('dashboard.total_sales_due') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-widget dash2 w-100">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash3.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>$<span class="counters"
                            data-count="{{ $totalSaleAmount }}">{{ number_format($totalSaleAmount, 2) }}</span></h5>
                    <h6>{{ __('dashboard.total_sale_amount') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-widget dash3 w-100">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash4.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>$<span class="counters"
                            data-count="{{ $totalExpenseAmount }}">{{ number_format($totalExpenseAmount, 2) }}</span></h5>
                    <h6>{{ __('dashboard.total_expense_amount') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-count">
                <div class="dash-counts">
                    <h4>{{ $customerCount }}</h4>
                    <h5>{{ __('dashboard.customers') }}</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="user"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das1">
                <div class="dash-counts">
                    <h4>{{ $supplierCount }}</h4>
                    <h5>{{ __('dashboard.suppliers') }}</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="user-check"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das2">
                <div class="dash-counts">
                    <h4>{{ $purchaseInvoiceCount }}</h4>
                    <h5>{{ __('dashboard.purchase_invoice') }}</h5>
                </div>
                <div class="dash-imgs">
                    <img src="assets/img/icons/file-text-icon-01.svg" class="img-fluid" alt="icon">
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das3">
                <div class="dash-counts">
                    <h4>{{ $salesInvoiceCount }}</h4>
                    <h5>{{ __('dashboard.sales_invoice') }}</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="file"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->

    <div class="row">
        <div class="col-xl-7 col-sm-12 col-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">{{ __('dashboard.purchase_and_sales') }}</h5>
                    <div class="graph-sets">
                        <ul class="mb-0">
                            <li>
                                <span>{{ __('dashboard.sales') }}</span>
                            </li>
                            <li>
                                <span>{{ __('dashboard.purchase') }}</span>
                            </li>
                        </ul>
                        <div class="dropdown dropdown-wraper">
                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ date('Y') }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item">{{ date('Y') }}</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item">{{ date('Y') - 1 }}</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item">{{ date('Y') - 2 }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="sales_charts"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-sm-12 col-12 d-flex">
            <div class="card flex-fill default-cover mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ __('dashboard.recent_medicines') }}</h4>
                    <div class="view-all-link">
                        <a href="{{ route('medicines.index') }}" class="view-all d-flex align-items-center">
                            {{ __('dashboard.view_all') }}<span class="ps-2 d-flex align-items-center"><i
                                    data-feather="arrow-right" class="feather-16"></i></span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive dataview">
                        <table class="table dashboard-recent-products">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('dashboard.products') }}</th>
                                    <th>{{ __('dashboard.price') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentProducts as $key => $product)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="productimgname">
                                            <a href="{{ route('medicines.show', $product->id) }}" class="product-img">
                                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                            </a>
                                            <a href="{{ route('medicines.show', $product->id) }}">{{ $product->name }}</a>
                                        </td>
                                        <td>${{ number_format($product->sale_price, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">{{ __('dashboard.no_products_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('dashboard.expired_medicines') }}</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive dataview">
                <table class="table dashboard-expired-products">
                    <thead>
                        <tr>
                            <th class="no-sort">
                                <label class="checkboxs">
                                    <input type="checkbox" id="select-all">
                                    <span class="checkmarks"></span>
                                </label>
                            </th>
                            <th>{{ __('dashboard.product') }}</th>
                            <th>{{ __('dashboard.sku') }}</th>
                            <th>{{ __('dashboard.manufactured_date') }}</th>
                            <th>{{ __('dashboard.expired_date') }}</th>
                            <th class="no-sort">{{ __('dashboard.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expiredProducts as $product)
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>
                                    <div class="productimgname">
                                        <a href="{{ route('medicines.show', $product->id) }}"
                                            class="product-img stock-img">
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                        </a>
                                        <a href="{{ route('medicines.show', $product->id) }}">{{ $product->name }}</a>
                                    </div>
                                </td>
                                <td><a href="{{ route('medicines.show', $product->id) }}">{{ $product->barcode }}</a>
                                </td>
                                <td>{{ $product->manufacturing_date ? date('d M Y', strtotime($product->manufacturing_date)) : 'N/A' }}
                                </td>
                                <td>{{ date('d M Y', strtotime($product->expiration_date)) }}</td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('medicines.edit', $product->id) }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="confirm-text p-2" href="javascript:void(0);">
                                            <i data-feather="trash-2" class="feather-trash-2"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('dashboard.no_expired_products_found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Here internal js use for dynamically change the chart data
        $(document).ready(function() {
            // Sales & Purchase Chart
            if ($('#sales_charts').length > 0) {
                var options = {
                    colors: ['#28C76F', '#FF4D4D'],
                    series: [{
                        name: "Sales",
                        type: "column",
                        data: @json($monthlySales)
                    }, {
                        name: "Purchase",
                        type: "column",
                        data: @json($monthlyPurchases)
                    }],
                    chart: {
                        type: 'bar',
                        fontFamily: 'Poppins, sans-serif',
                        height: 350,
                        toolbar: {
                            show: false,
                        },
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '60%',
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
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                            'Nov', 'Dec'
                        ],
                    },
                    yaxis: {
                        title: {
                            text: '{{ setting('currency_symbol') }}({{ setting('currency') }})'
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return "{{ setting('currency_symbol') }} " + val
                            }
                        }
                    }
                };
                var chart = new ApexCharts(document.querySelector("#sales_charts"), options);
                chart.render();
            }
        });
    </script>
@endpush
