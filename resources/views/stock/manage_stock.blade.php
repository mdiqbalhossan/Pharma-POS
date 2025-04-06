@extends('layouts.app')

@section('title', 'Manage Stocks')

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'Stock',
        'subtitle' => 'Manage your Stock',
    ])

    <div class="card table-list-card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-input">
                        <a href="" class="btn btn-searchset"><i data-feather="search" class="feather-search"></i></a>
                    </div>
                </div>
                <div class="search-path">
                    <div class="d-flex align-items-center">
                        <a class="btn btn-filter" id="filter_search">
                            <i data-feather="filter" class="filter-icon"></i>
                            <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                        </a>
                        <div class="form-sort">
                            <i data-feather="sliders" class="info-img"></i>
                            <select class="select" id="sort_by">
                                <option>Sort by Sale Price</option>
                                <option value="lowest">Lowest</option>
                                <option value="highest">Highest</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Filter -->
            <div class="card" id="filter_inputs">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="input-blocks">
                                <i data-feather="archive" class="info-img"></i>
                                <select class="select">
                                    <option>Choose Category</option>
                                    @foreach ($medicine_categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="input-blocks">
                                <i data-feather="box" class="info-img"></i>
                                <select class="select">
                                    <option>Choose Vendor</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 ms-auto">
                            <div class="input-blocks">
                                <a class="btn btn-filters ms-auto"> <i data-feather="search" class="feather-search"></i>
                                    Filter </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Filter -->
            <div class="table-responsive">
                <table class="table datanew">
                    <thead>
                        <tr>
                            <th class="no-sort">SN</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Generic Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th class="no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicines as $medicine)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($medicine->image)
                                        <img src="{{ Storage::url($medicine->image) }}" alt="{{ $medicine->name }}"
                                            class="img-thumbnail" width="50">
                                    @else
                                        <img src="{{ asset('assets/img/placeholder.png') }}" alt="{{ $medicine->name }}"
                                            class="img-thumbnail" width="50">
                                    @endif
                                </td>
                                <td>{{ $medicine->name }}</td>
                                <td>{{ $medicine->generic_name ?? 'N/A' }}</td>
                                <td>
                                    {{ $medicine->quantity }}
                                </td>
                                <td>{{ number_format($medicine->sale_price, 2) }}</td>


                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="p-2 me-2" href="{{ route('medicines.show', $medicine->id) }}"
                                            data-bs-toggle="tooltip" title="View">
                                            <i data-feather="eye" class="feather-eye"></i>
                                        </a>
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
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Datetimepicker JS -->
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/stock.js') }}"></script>
@endpush
