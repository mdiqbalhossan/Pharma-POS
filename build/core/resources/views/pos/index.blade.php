@extends('layouts.app')

@section('title', __('index.POS'))

@push('plugin')
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/owlcarousel/owl.theme.default.min.css') }}">
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')

    <div class="d-flex justify-content-between flex-column flex-sm-column flex-md-row mt-5 mt-sm-5 mt-md-2">
        {{-- Search and Barcode Scan Option --}}
        <div class="d-flex align-items-center w-sm-50 px-4 px-sm-4">
            <div class="input-group">
                <input type="text" class="form-control"
                    placeholder="{{ __('index.Search product by name or scan barcode...') }}" id="search-medicine">
                <button class="btn btn-primary m-0 m-sm-0"><i data-feather="camera" class="feather-16"></i></button>
            </div>
        </div>
        {{-- Action Button --}}
        <div class="btn-row d-sm-flex align-items-center">
            <a href="javascript:void(0);" class="btn btn-secondary mb-xs-3" data-bs-toggle="modal"
                data-bs-target="#orders"><span class="me-1 d-flex align-items-center"><i data-feather="shopping-cart"
                        class="feather-16"></i></span>{{ __('index.View Orders') }}</a>
            <a href="javascript:void(0);" class="btn btn-info" id="reset-pos"><span
                    class="me-1 d-flex align-items-center"><i data-feather="rotate-cw"
                        class="feather-16"></i></span>{{ __('index.Reset') }}</a>
            <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recents"><span
                    class="me-1 d-flex align-items-center"><i data-feather="refresh-ccw"
                        class="feather-16"></i></span>{{ __('index.Transaction') }}</a>
        </div>
    </div>



    <div class="row align-items-start pos-wrapper">
        <div class="col-md-12 col-lg-8">
            <div class="pos-categories tabs_wrapper">
                <div class="pos_categories_default">
                    <h5>{{ __('index.Categories') }}</h5>
                    <p>{{ __('index.Select From Below Categories') }}</p>
                    <ul class="tabs owl-carousel pos-category">
                        <li id="all">
                            <a href="javascript:void(0);">
                                <img src="assets/img/categories/category-01.png" alt="{{ __('index.Categories') }}">
                            </a>
                            <h6><a href="javascript:void(0);">{{ __('index.All Categories') }}</a></h6>
                            <span>{{ $medicineCategories->count() }} {{ __('index.Items') }}</span>
                        </li>
                        @foreach ($medicineCategories as $category)
                            <li id="{{ $category->slug }}">
                                <a href="javascript:void(0);">
                                    <img src="{{ $category->image }}" alt="{{ __('index.Categories') }}">
                                </a>
                                <h6><a href="javascript:void(0);">{{ $category->name }}</a></h6>
                                <span>{{ $category->medicine_count }} {{ __('index.Items') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="pos-products pos_products_default">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-3">{{ __('index.Products') }}</h5>
                    </div>
                    <div class="tabs_container">
                        <div class="tab_content active" data-tab="all">
                            <div class="row">
                                @forelse ($medicines as $medicine)
                                    <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3 pe-2 mb-3">
                                        <div class="product-info default-cover card" data-id="{{ $medicine->id }}">
                                            <a href="javascript:void(0);" class="img-bg">
                                                <img src="{{ $medicine->image }}" alt="{{ __('index.Products') }}">
                                                @if ($medicine->quantity > 0)
                                                    <span><i data-feather="check" class="feather-16"></i></span>
                                                @else
                                                    <span class="bg-danger"><i data-feather="x-circle"
                                                            class="feather-16"></i></span>
                                                @endif
                                            </a>
                                            <h6 class="cat-name"><a
                                                    href="javascript:void(0);">{{ $medicine->generic_name }}</a></h6>
                                            <h6 class="product-name"><a
                                                    href="javascript:void(0);">{{ $medicine->name }}</a></h6>
                                            <div class="d-flex align-items-center justify-content-between price">
                                                <span>{{ $medicine->quantity }} {{ $medicine->unit->name }}</span>
                                                <p>{{ show_amount($medicine->sale_price) }}</p>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-primary mt-2 alternate-med-btn"
                                            data-id="{{ $medicine->id }}">
                                            <i data-feather="repeat"
                                                class="feather-14 me-1"></i>{{ __('index.Alternatives Medicines') }}
                                        </button>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="alert alert-warning">{{ __('index.No medicines found') }}</div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        @foreach ($medicineCategories as $category)
                            <div class="tab_content" data-tab="{{ $category->slug }}">
                                <div class="row">
                                    @forelse ($category->medicines as $medicine)
                                        <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3 pe-2 mb-3">
                                            <div class="product-info default-cover card" data-id="{{ $medicine->id }}">
                                                <a href="javascript:void(0);" class="img-bg">
                                                    <img src="{{ $medicine->image }}" alt="{{ __('index.Products') }}">
                                                    @if ($medicine->quantity > 0)
                                                        <span><i data-feather="check" class="feather-16"></i></span>
                                                    @else
                                                        <span><i data-feather="x-circle" class="feather-16"></i></span>
                                                    @endif
                                                </a>
                                                <h6 class="cat-name"><a
                                                        href="javascript:void(0);">{{ $medicine->generic_name }}</a></h6>
                                                <h6 class="product-name"><a
                                                        href="javascript:void(0);">{{ $medicine->name }}</a></h6>
                                                <div class="d-flex align-items-center justify-content-between price">
                                                    <span>{{ $medicine->quantity }} {{ $medicine->unit->name }}</span>
                                                    <p>{{ show_amount($medicine->sale_price) }}</p>
                                                </div>
                                            </div>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary mt-2 alternate-med-btn"
                                                data-id="{{ $medicine->id }}">
                                                <i data-feather="repeat"
                                                    class="feather-14 me-1"></i>{{ __('index.Alternatives Medicines') }}
                                            </button>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="alert alert-warning">{{ __('index.No medicines found') }}</div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="pos-products pos_products_search d-none">
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4 ps-0">
            <aside class="product-order-list">
                <div class="head d-flex align-items-center justify-content-between w-100">
                    <div class="">
                        <h5>{{ __('index.Order List') }}</h5>
                        <span>{{ __('index.Sale ID') }} : #<span class="sales_id">{{ $saleNumber }}</span></span>
                    </div>
                </div>
                <div class="customer-info block-section">
                    <h6>{{ __('index.Customer Information') }}</h6>
                    <div class="input-block d-flex align-items-center">
                        <div class="flex-grow-1">
                            <select class="select">
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ $customer->id == 1 ? 'selected' : '' }}>
                                        {{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <a href="#" class="btn btn-primary btn-icon" data-bs-toggle="modal"
                            data-bs-target="#create"><i data-feather="user-plus" class="feather-16"></i></a>
                    </div>

                </div>

                <div class="product-added block-section">
                    <div class="head-text d-flex align-items-center justify-content-between">
                        <h6 class="d-flex align-items-center mb-0">{{ __('index.Product Added') }}<span class="count"
                                id="product-count">0</span></h6>
                        <a href="javascript:void(0);" class="d-flex align-items-center text-danger" id="clear-cart"><span
                                class="me-1"><i data-feather="x"
                                    class="feather-16"></i></span>{{ __('index.Clear all') }}</a>
                    </div>
                    <div class="product-wrap cart-product-wrap">
                        <div class="alert alert-warning d-flex align-items-center gap-2" role="alert">
                            <i data-feather="alert-triangle" class="feather-16"></i>
                            <div>
                                {{ __('index.No products added') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-section">
                    <div class="selling-info">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="input-block">
                                    <label>{{ __('index.Order Tax (%)') }}</label>
                                    <input type="number" class="form-control" placeholder="{{ __('index.Order Tax') }}"
                                        id="tax-input">
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="input-block">
                                    <label>{{ __('index.Shipping') }}</label>
                                    <input type="number" class="form-control" placeholder="{{ __('index.Shipping') }}"
                                        id="shipping-input">
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="input-block">
                                    <label>{{ __('index.Discount (%)') }}</label>
                                    <input type="number" class="form-control" placeholder="{{ __('index.Discount') }}"
                                        id="discount-input">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-total">
                        <table class="table table-responsive table-borderless">
                            <tr>
                                <td>{{ __('index.Sub Total') }}</td>
                                <td class="text-end" id="sub-total">0</td>
                            </tr>
                            <tr>
                                <td>{{ __('index.Tax') }}</td>
                                <td class="text-end" id="tax">0</td>
                            </tr>
                            <tr>
                                <td>{{ __('index.Shipping') }}</td>
                                <td class="text-end" id="shipping">0</td>
                            </tr>
                            <tr>
                                <td class="danger">{{ __('index.Discount') }}</td>
                                <td class="danger text-end" id="discount">0</td>
                            </tr>
                            <tr>
                                <td>{{ __('index.Total') }}</td>
                                <td class="text-end" id="total">0</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="block-section payment-method">
                    <h6>{{ __('index.Payment Method') }}</h6>
                    <div class="row d-flex align-items-center justify-content-center methods">
                        @if (setting('payment_cash_enabled'))
                            <div class="col-sm-6 col-md-4 col-lg-4 item">
                                <div class="default-cover payment-option">
                                    <input type="radio" id="payment-cash" name="payment-method" value="cash"
                                        class="payment-radio" checked>
                                    <label for="payment-cash">
                                        <img src="{{ asset('assets/img/icons/cash-pay.svg') }}"
                                            alt="{{ __('index.Payment Method') }}">
                                        <span>{{ __('index.Cash') }}</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                        @if (setting('payment_card_enabled'))
                            <div class="col-sm-6 col-md-4 col-lg-4 item">
                                <div class="default-cover payment-option">
                                    <input type="radio" id="payment-card" name="payment-method" value="card"
                                        class="payment-radio">
                                    <label for="payment-card">
                                        <img src="{{ asset('assets/img/icons/credit-card.svg') }}"
                                            alt="{{ __('index.Payment Method') }}">
                                        <span>{{ __('index.Card') }}</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                        @if (setting('payment_bank_enabled'))
                            <div class="col-sm-6 col-md-4 col-lg-4 item">
                                <div class="default-cover payment-option">
                                    <input type="radio" id="payment-bank" name="payment-method" value="bank"
                                        class="payment-radio">
                                    <label for="payment-bank">
                                        <img src="{{ asset('assets/img/icons/qr-scan.svg') }}"
                                            alt="{{ __('index.Payment Method') }}">
                                        <span>{{ __('index.Bank') }}</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                        @if (setting('payment_cheque_enabled'))
                            <div class="col-sm-6 col-md-4 col-lg-4 item">
                                <div class="default-cover payment-option">
                                    <input type="radio" id="payment-cheque" name="payment-method" value="cheque"
                                        class="payment-radio">
                                    <label for="payment-cheque">
                                        <img src="{{ asset('assets/img/icons/qr-scan.svg') }}"
                                            alt="{{ __('index.Payment Method') }}">
                                        <span>{{ __('index.Cheque') }}</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="d-grid btn-block">
                    <a class="btn btn-secondary" href="javascript:void(0);">
                        Grand Total : <span id="grand-total-value">0</span>
                    </a>
                </div>
                <div class="btn-row d-sm-flex align-items-center justify-content-between">
                    <a href="javascript:void(0);" class="btn btn-info btn-icon flex-fill hold-order"><span
                            class="me-1 d-flex align-items-center"><i data-feather="pause"
                                class="feather-16"></i></span>Hold</a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-icon flex-fill void-order"><span
                            class="me-1 d-flex align-items-center"><i data-feather="trash-2"
                                class="feather-16"></i></span>Void</a>
                    <a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill" id="payment-btn"><span
                            class="me-1 d-flex align-items-center"><i data-feather="credit-card"
                                class="feather-16"></i></span>Payment</a>
                </div>

            </aside>
        </div>
    </div>

    @include('pos.include._payment_complete')
    @include('pos.include._payment_modal')
    @include('pos.include._hold_order')
    @include('pos.include._print_receipt')
    @include('pos.include._recent_transaction')
    @include('pos.include._orders')
    @include('pos.include._customer')
    @include('pos.include._products')
    @include('pos.include._keyboard_shortcut')

    <!-- Alternate Medicines Modal -->
    @include('pos.include._alternate_modal')

@endsection

@push('script')
    <!-- Owl JS -->
    <script src="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.js') }}"></script>
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <!-- Howler JS -->
    <script src="{{ asset('assets/js/howler.min.js') }}"></script>
    <!-- POS JS -->
    <script src="{{ asset('assets/js/pages/pos.js') }}"></script>
    <!-- Keyboard Shortcuts JS -->
    <script src="{{ asset('assets/js/pages/keyboardshortcut.js') }}"></script>
@endpush
