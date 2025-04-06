<div class="modal fade pos-modal" id="orders" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header p-4">
                <h5 class="modal-title">Orders</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="tabs-sets">
                    <ul class="nav nav-tabs" id="myTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="onhold-tab" data-bs-toggle="tab"
                                data-bs-target="#onhold" type="button" aria-controls="onhold" aria-selected="true"
                                role="tab">Onhold</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="unpaid-tab" data-bs-toggle="tab" data-bs-target="#unpaid"
                                type="button" aria-controls="unpaid" aria-selected="false"
                                role="tab">Unpaid</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="paid-tab" data-bs-toggle="tab" data-bs-target="#paid"
                                type="button" aria-controls="paid" aria-selected="false" role="tab">Paid</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled"
                                type="button" aria-controls="cancelled" aria-selected="false"
                                role="tab">Cancelled</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="onhold" role="tabpanel"
                            aria-labelledby="onhold-tab">
                            <div class="table-top">
                                <div class="search-set w-100 search-order">
                                    <div class="search-input w-100">
                                        <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                                src="assets/img/icons/search-white.svg" alt="img"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="order-body">
                                @forelse ($holdOrders as $order)
                                    <div class="default-cover p-4 mb-4">
                                        <span class="badge bg-secondary d-inline-block mb-4">Order ID :
                                            #{{ $order->sale_no }}</span>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr class="mb-3">
                                                        <td>Cashier</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->user->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Customer</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->customer->name }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->grand_total }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->sale_date }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <p class="p-4">Customer need to recheck the product once</p>
                                        <div class="btn-row d-sm-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);"
                                                class="btn btn-info btn-icon flex-fill open-order"
                                                data-id="{{ $order->id }}">Open</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-danger btn-icon flex-fill view-products"
                                                data-id="{{ $order->id }}"
                                                data-sale-no="{{ $order->sale_no }}">Products</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-success btn-icon flex-fill print-receipt"
                                                data-id="{{ $order->id }}">Print</a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-warning">No orders found</div>
                                @endforelse
                            </div>

                        </div>
                        <div class="tab-pane fade" id="unpaid" role="tabpanel">
                            <div class="table-top">
                                <div class="search-set w-100 search-order">
                                    <div class="search-input">
                                        <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                                src="assets/img/icons/search-white.svg" alt="img"></a>
                                    </div>
                                </div>

                            </div>
                            <div class="order-body">
                                @forelse ($unpaidOrders as $order)
                                    <div class="default-cover p-4 mb-4">
                                        <span class="badge bg-info d-inline-block mb-4">Order ID :
                                            #{{ $order->sale_no }}</span>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr class="mb-3">
                                                        <td>Cashier</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->user->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Customer</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->customer->name }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->grand_total }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->sale_date }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <p class="p-4">Customer need to recheck the product once</p>
                                        <div class="btn-row d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);"
                                                class="btn btn-info btn-icon flex-fill open-order"
                                                data-id="{{ $order->id }}">Open</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-danger btn-icon flex-fill view-products"
                                                data-id="{{ $order->id }}"
                                                data-sale-no="{{ $order->sale_no }}">Products</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-success btn-icon flex-fill print-receipt"
                                                data-id="{{ $order->id }}">Print</a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-warning">No orders found</div>
                                @endforelse
                            </div>
                        </div>
                        <div class="tab-pane fade" id="paid" role="tabpanel">
                            <div class="table-top">
                                <div class="search-set w-100 search-order">
                                    <div class="search-input">
                                        <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                                src="assets/img/icons/search-white.svg" alt="img"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="order-body">
                                @forelse ($paidOrders as $order)
                                    <div class="default-cover p-4 mb-4">
                                        <span class="badge bg-primary d-inline-block mb-4">Order ID :
                                            #{{ $order->sale_no }}</span>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr class="mb-3">
                                                        <td>Cashier</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->user->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Customer</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->customer->name }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->grand_total }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->sale_date }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <p class="p-4">Customer need to recheck the product once</p>
                                        <div class="btn-row d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);"
                                                class="btn btn-danger btn-icon flex-fill view-products"
                                                data-id="{{ $order->id }}"
                                                data-sale-no="{{ $order->sale_no }}">Products</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-success btn-icon flex-fill print-receipt"
                                                data-id="{{ $order->id }}">Print</a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-warning">No orders found</div>
                                @endforelse
                            </div>
                        </div>
                        <div class="tab-pane fade" id="cancelled" role="tabpanel">
                            <div class="table-top">
                                <div class="search-set w-100 search-order">
                                    <div class="search-input">
                                        <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                                src="assets/img/icons/search-white.svg" alt="img"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="order-body">
                                @forelse ($cancelledOrders as $order)
                                    <div class="default-cover p-4 mb-4">
                                        <span class="badge bg-danger d-inline-block mb-4">Order ID :
                                            #{{ $order->sale_no }}</span>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr class="mb-3">
                                                        <td>Cashier</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->user->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Customer</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->customer->name }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->grand_total }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->sale_date }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="btn-row d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);"
                                                class="btn btn-danger btn-icon flex-fill view-products"
                                                data-id="{{ $order->id }}"
                                                data-sale-no="{{ $order->sale_no }}">Products</a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-warning">No orders found</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
