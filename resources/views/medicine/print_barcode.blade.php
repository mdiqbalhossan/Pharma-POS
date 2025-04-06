@extends('layouts.app')

@section('title', 'Barcode Generate')

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
@endpush

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Print Barcode</h4>
                <h6>Manage your barcodes</h6>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <ul class="table-top-head">
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i data-feather="rotate-ccw"
                            class="feather-rotate-ccw"></i></a>
                </li>
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                            data-feather="chevron-up" class="feather-chevron-up"></i></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="barcode-content-list">
        <form id="barcode-form" action="{{ route('barcode.generate') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="row seacrh-barcode-item">
                        <div class="col-sm-12 mb-3 seacrh-barcode-item-one">
                            <label class="form-label">Select Vendor</label>
                            <select class="select2" name="vendor_id" id="vendor_id">
                                <option value="">Choose</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-blocks search-form seacrh-barcode-item">
                        <div class="searchInput">
                            <label class="form-label">Product</label>
                            <input type="text" class="form-control" id="medicine_search"
                                placeholder="Search Product by Name or Code">
                            <div class="resultBox">
                            </div>
                            <div class="icon"><i class="fas fa-search"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="modal-body-table search-modal-header">
                    <div class="table-responsive">
                        <table class="table datanew" id="barcode-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Code</th>
                                    <th>Qty</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Products will be added here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="paper-search-size">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="mb-0">
                            <label class="form-label">Paper Size</label>
                            <select class="select" name="paper_size" id="paper_size">
                                <option value="small">Small (2.5" x 1")</option>
                                <option value="medium">Medium (3" x 2")</option>
                                <option value="large">Large (4" x 3")</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 pt-3">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="search-toggle-list">
                                    <p>Show Vendor Name</p>
                                    <div class="input-blocks m-0">
                                        <div
                                            class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                            <input type="checkbox" id="show_vendor_name" name="show_vendor_name"
                                                class="check" value="1" checked>
                                            <label for="show_vendor_name" class="checktoggle mb-0"> </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="search-toggle-list">
                                    <p>Show Product Name</p>
                                    <div class="input-blocks m-0">
                                        <div
                                            class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                            <input type="checkbox" id="show_product_name" name="show_product_name"
                                                class="check" value="1" checked>
                                            <label for="show_product_name" class="checktoggle mb-0"> </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="search-toggle-list">
                                    <p>Show Price</p>
                                    <div class="input-blocks m-0">
                                        <div
                                            class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                            <input type="checkbox" id="show_price" name="show_price" class="check"
                                                value="1" checked>
                                            <label for="show_price" class="checktoggle mb-0"> </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="search-barcode-button">
                <button type="submit" class="btn btn-submit me-2">
                    <span><i class="fas fa-eye me-2"></i></span>
                    Generate Barcode
                </button>
                <a href="javascript:void(0);" id="reset-barcode" class="btn btn-cancel me-2">
                    <span><i class="fas fa-power-off me-2"></i></span>
                    Reset Barcode
                </a>
                <button type="button" id="print-barcode" class="btn btn-cancel close-btn">
                    <span><i class="fas fa-print me-2"></i></span>
                    Print Barcode
                </button>
            </div>
        </form>
    </div>
@endsection
@push('script')
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>

    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <!-- jQuery UI JS -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Print Barcode -->
    <script src="{{ asset('assets/js/pages/print_barcode.js') }}"></script>
@endpush
