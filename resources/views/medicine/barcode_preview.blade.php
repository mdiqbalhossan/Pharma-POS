@extends('layouts.app')

@section('title', __('medicine.barcode_preview'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <style>
        .barcode-item {
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px dashed #ddd;
        }

        .barcode-container {
            padding: 15px;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                margin: 0;
                padding: 0;
            }

            .barcode-container {
                padding: 0;
            }

            .barcode-item {
                border: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-header no-print">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>{{ __('medicine.barcode_preview') }}</h4>
                <h6>{{ __('medicine.preview_and_print_barcodes') }}</h6>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <ul class="table-top-head">
                <li>
                    <a href="{{ route('print.barcode') }}" class="btn btn-secondary me-2"><i data-feather="arrow-left"
                            class="me-2"></i>{{ __('medicine.back') }}</a>
                </li>
                <li>
                    <button class="btn btn-primary" id="print_btn">
                        <i data-feather="printer" class="me-2"></i>{{ __('medicine.print_barcode') }}
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <div class="barcode-container">
        <div class="row">
            @if (!empty($products))
                @foreach ($products as $product)
                    @for ($i = 0; $i < $product['quantity']; $i++)
                        <div class="col-{{ $paperSize == 'large' ? '4' : ($paperSize == 'medium' ? '3' : '2') }}">
                            <div class="barcode-item">
                                @if ($showVendorName && isset($vendor))
                                    <p class="mb-1"><strong>{{ $vendor->name }}</strong></p>
                                @endif

                                @if ($showProductName)
                                    <p class="mb-1">{{ $product['name'] }}</p>
                                @endif

                                <div class="barcode-image">
                                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($product['barcode'], barcode_type(setting('barcode_type')), 1, 50) }}"
                                        alt="barcode" class="img-fluid">
                                </div>
                                <div class="barcode-text">
                                    <small>{{ $product['barcode'] ?? $product['generic_name'] }}</small>
                                </div>

                                @if ($showPrice)
                                    <p class="mt-1"><strong>{{ __('medicine.price') }}:
                                            ${{ number_format($product['price'], 2) }}</strong></p>
                                @endif
                            </div>
                        </div>
                    @endfor
                @endforeach
            @else
                <div class="col-12 text-center">
                    <h5>{{ __('medicine.no_products_selected') }}</h5>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('script')
    <!-- Print Barcode -->
    <script>
        $(document).ready(function() {
            "use strict";
            // Print Barcode
            $(document).on("click", "#print_btn", function() {
                let container = $(".barcode-container");

                let printWindow = window.open('', '_blank');
                printWindow.document.write(
                    '<html><head><title>{{ __('medicine.barcode_print') }}</title>');
                printWindow.document.write(
                    `<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">`);
                printWindow.document.write(
                    `<style>body{padding:15px;}</style>`);
                printWindow.document.write('</head><body>');
                printWindow.document.write(container.html());
                printWindow.document.write('</body></html>');
                printWindow.document.close();

                printWindow.onload = function() {
                    printWindow.focus();
                    printWindow.print();
                };

                // After print save or close then close the print window
                printWindow.onbeforeunload = function() {
                    printWindow.close();
                };
            });
        });
    </script>
@endpush
